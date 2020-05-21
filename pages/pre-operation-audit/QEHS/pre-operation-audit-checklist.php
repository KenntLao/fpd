<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-QEHS-checklist')) {

    $page = 'pre-operation-audit';
    
    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT * FROM pre_operation_audit WHERE id = :id LIMIT 1");
    $sql->bindParam(":id", $id);
    $sql->execute();
    $_data = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo renderLang($pre_operation_audit_checklist); ?> &middot; <?php echo $sitename; ?></title>
    
	<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/assets/css/pre-operation-audit.css">
	
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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_checklist); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_pre_operation_audit_add_suc');
                    renderError('sys_pre_operation_audit_add_err');
                    ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_form); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-<?php echo $audit_status_color_arr[$_data['status']] ?>"><?php echo renderLang($audit_status_arr[$_data['status']]); ?></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="department" value="QEHS">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="project_id"><?php echo renderLang($pre_operation_audit_project); ?></label>
                                            <?php 
                                            $sql = $pdo->prepare("SELECT * FROM prospecting WHERE status = 3 AND prospecting_category = 0 AND temp_del = 0");
                                            $sql->execute();
                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                            echo '<input type="text" class="form-control input-readonly" name="project_id" id="project_id" value="['.$data['reference_number'].'] '.$data['project_name'].'" readonly>';
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="auditee"><?php echo renderLang($pre_operation_audit_auditee); ?></label>
                                            <input type="text" class="form-control input-readonly" name="auditee" id="auditee" value="<?php echo $_data['auditee']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date"><?php echo renderLang($pre_operation_audit_date_of_audit); ?></label>
                                            <input type="text" class="form-control input-readonly" id="date" value="<?php echo formatDate($_data['date_of_audit']); ?>" readonly disabled>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="auditors"><?php echo renderLang($pre_operation_audit_auditors); ?></label>
                                            <ul>
                                                <?php 
                                                $employee_ids = explode(',', $_data['auditors']);

                                                $sql = $pdo->prepare("SELECT * FROM employees WHERE temp_del = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    $full_name = $data['firstname'].' '.$data['lastname'];
                                                    echo '<li class="'.(in_array($data['id'], $employee_ids) ? ' ' : 'd-none').'">'. $full_name.'</li>';
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col=lg-6 col-md-12">
                                        <ul style="list-style-type: none;">
                                            <?php 
                                            foreach($pre_op_audit_qehs_legend_arr as $key => $legend) {
                                                echo '<li class="p-2">';
                                                    echo '<button data-color="'.$legend[0].'" class="btn btn-'.$legend[0].' btn-legend '.($key == 0 ? '' : '').'" ></button><span class="ml-2">'.renderLang($legend[1]).'</span>';
                                                echo '</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                </div>

                                <?php foreach($pre_operation_audit_categories_arr as $category) { ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-center">
                                                <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-<?php echo str_replace(' ', '-', strtolower($category[0])); ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($category); ?></button>
                                            </p>
                                            <div class="collapse" id="tab-<?php echo str_replace(' ', '-', strtolower($category[0])); ?>">

                                                <div class="card card-body">

                                                    <div class="row">
                                                        <div class="col-12 table-responsive mh500p">
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="w75"><?php echo renderLang($pre_operation_audit_iso_clause); ?></th>
                                                                        <th class="w200"><?php echo renderLang($pre_operation_audit_reference_document); ?></th>
                                                                        <th class="w300"><?php echo renderLang($pre_operation_audit_items_to_check); ?></th>
                                                                        <th class="w55"><?php echo renderLang($lang_yes); ?></th>
                                                                        <th class="w55"><?php echo renderLang($lang_no); ?></th>
                                                                        <th class="w300"><?php echo renderLang($pre_operation_audit_compliances_gaps); ?></th>
                                                                        <th class="w300"><?php echo renderLang($pre_operation_audit_actions); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="table-data">
                                                                <?php
                                                                $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_checklist WHERE audit_id = :audit_id");
                                                                $sql->bindParam(":audit_id", $id);
                                                                $sql->execute();
                                                                $check = array();
                                                                $check_status = array();
                                                                $check_compliance = array();
                                                                $check_actions = array();
                                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                    $check[$data['checklist_id']] = array(
                                                                            $data['checklist_id'],
                                                                            $data['check_status'],
                                                                            $data['color_code'],
                                                                            $data['compliances'],
                                                                            $data['actions']
                                                                        );

                                                                }

                                                                $cat = strtolower($category[0]);
                                                                $sql = $pdo->prepare("SELECT * FROM pre_operation_checklist WHERE temp_del = 0 AND parent IS NULL AND category = :category");
                                                                $sql->bindParam(":category", $cat);
                                                                $sql->execute();
                                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                    echo '<tr>';

                                                                    if(strpos($data['iso_clause'], ',')) {
                                                                        $clause = explode(',',$data['iso_clause']);
                                                                        $clause = implode('<br>', $clause);
                                                                    } else {
                                                                        $clause = $data['iso_clause'];
                                                                    }

                                                                    $exist = isset($check[$data['id']]) ? 1 : 0;

                                                                    echo '<td>';
                                                                        echo $clause;
                                                                        echo '<input type="hidden" name="checklist_id[]" value="'.$data['id'].'">';
                                                                    echo '</td>';

                                                                    echo '<td><b>'.$data['reference_document'].'</b></td>';
                                                                    echo '<td><p>'.$data['item'].'</p></td>';
                                                                    echo '<td class="chk text-center"><button class="btn btn-'.($exist ? $check[$data['id']][2] : 'warning').' '.($exist ? $check[$data['id']][1] != 'E' ? 'd-none' : '' : 'd-none').' E" data-val="E"><i class="fa fa-check"></i></button></td>';
                                                                    echo '<td class="chk text-center"><button class="btn btn-'.($exist ? $check[$data['id']][2] : 'warning').' '.($exist ? $check[$data['id']][1] != 'NE' ? 'd-none' : '' : 'd-none').' NE" data-val="NE"><i class="fa fa-check"></i></button></td>';
                                                                    echo '<td class="w300"><p>'.($exist ? $check[$data['id']][3] : '').'</p></td>';
                                                                    echo '<td><p>'.($exist ? $check[$data['id']][4] : '').'</p></td>';
                                                                    echo '<input type="hidden" name="type[]" value="'.($exist ? $check[$data['id']][1] : '').'">';

                                                                    echo '</tr>';

                                                                    // get all child
                                                                    $sql1 = $pdo->prepare("SELECT * FROM pre_operation_checklist WHERE parent = :id ORDER BY id ASC");
                                                                    $sql1->bindParam(":id", $data['id']);
                                                                    $sql1->execute();
                                                                    while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {

                                                                        echo '<tr>';

                                                                            if(strpos($data1['iso_clause'], ',')) {
                                                                                $clause = explode(',',$data1['iso_clause']);
                                                                                $clause = implode('<br>', $clause);
                                                                            } else {
                                                                                $clause = $data1['iso_clause'];
                                                                            }

                                                                            $exist = isset($check[$data1['id']]) ? 1 : 0;

                                                                            echo '<td>';
                                                                                echo $clause;
                                                                                echo '<input type="hidden" name="checklist_id[]" value="'.$data1['id'].'">';
                                                                            echo '</td>';

                                                                            echo '<td>'.$data1['reference_document'].'</td>';
                                                                            echo '<td><p class="pl-2">'.$data1['item'].'</p></td>';
                                                                            echo '<td class="chk text-center"><button class="btn btn-'.($exist ? $check[$data1['id']][2] : 'warning').' '.($exist ? $check[$data1['id']][1] != 'E' ? 'd-none' : '' : 'd-none').' E" data-val="E"><i class="fa fa-check"></i></button></td>';
                                                                            echo '<td class="chk text-center"><button class="btn btn-'.($exist ? $check[$data1['id']][2] : 'warning').' '.($exist ? $check[$data1['id']][1] != 'NE' ? 'd-none' : '' : 'd-none').' NE" data-val="NE"><i class="fa fa-check"></i></button></td>';
                                                                            echo '<td class="w300"><p>'.($exist ? $check[$data1['id']][3] : '').'</p></td>';
                                                                            echo '<td><p>'.($exist ? $check[$data1['id']][4] : '').'</p></td>';
                                                                            echo '<input type="hidden" name="type[]" value="'.($exist ? $check[$data1['id']][1] : '').'">';

                                                                        echo '</tr>';

                                                                    }

                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- OTHERS -->
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-others" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_others); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-others">

                                            <div class="card card-body">

                                                <div class="row">
                                                    <div class="col-12 table-responsive mh500p">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th><?php echo renderLang($pre_operation_audit_iso_clause); ?></th>
                                                                    <th><?php echo renderLang($pre_operation_audit_reference_document); ?></th>
                                                                    <th><?php echo renderLang($pre_operation_audit_items_to_check); ?></th>
                                                                    <th class="w55">N</th>
                                                                    <th class="w55">NE</th>
                                                                    <th><?php echo renderLang($pre_operation_audit_compliances_gaps); ?></th>
                                                                    <th><?php echo renderLang($pre_operation_audit_actions); ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="table-data">
                                                                <tr id="default-row">
                                                                    <td><input type="text" class="form-control border-0"></td>
                                                                    <td><input type="text" class="form-control border-0"></td>
                                                                    <td><input type="text" class="form-control border-0"></td>
                                                                    <td><button class="btn btn-warning d-none E" data-val="E"><i class="fa fa-check"></i></button></td>
                                                                    <td><button class="btn btn-warning d-none NE" data-val="NE"><i class="fa fa-check"></i></button></td>
                                                                    <td><input type="text" class="form-control border-0"></td>
                                                                    <td><input type="text" class="form-control border-0"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="text-right">
                                                            <button href="" id="add-row" class="btn btn-info"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div> -->

                                
                                <?php if(checkPermission('pre-operation-audit-QEHS-comments')) { ?>
                                <!-- comment box -->
                                    <?php 
                                    $sql = $pdo->prepare("SELECT * FROM comments WHERE module = 'pre-operation-audit-QEHS' AND module_type = 'approval' AND module_id = :id AND temp_del = 0 ORDER BY comment_date DESC");
                                    $sql->bindParam(":id", $id);
                                    $sql->execute();
                                    if($sql->rowCount()) {
                                    ?>
                                    <div class="row mt-4">
                                        <div class="col-lg-6">

                                            <div class="card direct-chat direct-chat-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title"><?php echo renderLang($lang_comments); ?></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="direct-chat-messages">

                                                        <?php 
                                                        if($sql->rowCount()) {
                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                
                                                                if($_SESSION['sys_id'] == $data['user_id'] && $_SESSION['sys_account_mode'] == $data['user_account_mode']) {
                                                                echo '<div class="direct-chat-msg right">';
                                                                    echo '<div class="direct-chat-info clearfix">';

                                                                        echo '<span class="direct-chat-name float-right">'.getFullName($data['user_id'], $data['user_account_mode']).'</span>';
                                                                        echo '<span class="direct-chat-timestamp float-left">'.formatDate($data['comment_date'], true, false, true).'</span>';

                                                                        echo '</div>';

                                                                        echo '<img class="direct-chat-img" src="'.$_SESSION['sys_photo'].'" alt="message user image">';

                                                                        echo '<div class="direct-chat-text">';
                                                                            echo $data['comment'];
                                                                        echo '</div>';

                                                                echo '</div>';

                                                                } else {

                                                                echo '<div class="direct-chat-msg">';
                                                                    echo '<div class="direct-chat-info clearfix">';

                                                                        echo '<span class="direct-chat-name float-left">'.getFullName($data['user_id'], $data['user_account_mode']).'</span>';
                                                                        echo '<span class="direct-chat-timestamp float-right">'.formatDate($data['comment_date'], true, false, true).'</span>';

                                                                    echo '</div>';

                                                                        if($data['user_account_mode'] == 'user') {
                                                                            $photo = '/assets/images/profile/default.png';
                                                                        } else {
                                                                            $gender = getField('gender', 'employees', 'id = '.$data['user_id']);
                                                                            $photo = getField('photo', 'employees', 'id = '.$data['user_id']);
                                                                            if(!checkVar($photo)) {
                                                                                switch($gender) {
                                                                                    case 0:
                                                                                        $photo = '/dist/img/avatar2.png';
                                                                                        break;
                                                                                    case 1:
                                                                                        $photo = '/dist/img/avatar5.png';
                                                                                }
                                                                            }
                                                                        }

                                                                        echo '<img class="direct-chat-img" src="'.(!empty($photo) ? $photo : '/dist/img/avatar2.png').'" alt="message user image">';

                                                                        echo '<div class="direct-chat-text">';
                                                                            echo $data['comment'];
                                                                        echo '</div>';
                                                                echo '</div>';

                                                                }

                                                                    
                                                            }
                                                        } else {
                                                            echo 'No Comment Yet.';
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <?php if(checkPermission('pre-operation-audit-QEHS-comment-add')) { ?>
                                                        <div class="input-group">
                                                            <input type="text" name="comment" placeholder="" class="form-control">
                                                            <span class="input-group-append">
                                                                <button type="button" id="add-comment" class="btn btn-primary">Send</button>
                                                            </span>
                                                        </div>
                                                        <p id="err_msg" class="error-message text-danger mt-1"></p>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php 
                                    }
                                } 
                                ?>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/pre-operation-audits" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <?php if(checkPermission('pre-operation-audit-QEHS-edit') && $_data['status'] != 3 && $_data['status'] != 1) { ?>
                                <button class="btn btn-success" id="submit-btn"><i class="fa fa-save mr-1"></i><?php echo $_data['status'] ? renderLang($lang_for_submission) : renderLang($lang_save_as_draft); ?></button>
                                <?php } ?>
                            </div>
                        </div>

                </div>

			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

  <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<script>
		$(function(){

            $('#save-status').on('change', function(e){
                
                var status = $(this).val();
                if(status == '1') {
                    $('#submit-btn').html('<i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save_as_draft); ?>');
                    $(this).val('0');
                    $(this).closest('div').find('label').html('<?php echo renderLang($lang_save_as_draft); ?>');
                } else {
                    $('#submit-btn').html('<i class="fa fa-save mr-1"></i><?php echo renderLang($lang_for_submission); ?>');
                    $(this).val('1');
                    $(this).closest('div').find('label').html('<?php echo renderLang($lang_for_submission); ?>');
                }

            });

            $('.duallistbox').bootstrapDualListbox();

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
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