<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('prf-edit')) {

		// set page
		$page = 'prf';

		$id = $_GET['id'];

        $sql = $pdo->prepare("SELECT prf.attachment,  prf.id, project_name, p.reference_number, p.project_name FROM prf JOIN prospecting p ON prf.prospect_id=p.id WHERE prf.id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($prf_edit_prf); ?> &middot; <?php echo $sitename; ?></title>

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
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-people-carry mr-3"></i><?php echo renderLang($prf_edit_prf); ?>
							<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['project_name']; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_prf_edit_err');
					?>
					
					<form method="post" action="/submit-edit-prf" enctype="multipart/form-data">

						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($prf_edit_prf_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('prf-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($prf_delete_prf); ?></a><?php } ?>
                                </div>
							</div>
							<div class="card-body">

								<div class="row">
									
									<!-- PROJECT NAME -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="prospect_id" ><?php echo renderLang($contract_project_name); ?></label>
                                            <select class="form-control select2" id="prospect_id" name="prospect_id">
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_properties_add_client_id_val'])) {
													$select_val = $_SESSION['sys_properties_add_client_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM prospecting WHERE temp_del = 0 AND status = 3 AND prospecting_category = 0 ORDER BY project_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                    // check if already created
                                                    $exist = getField('id', 'prf', 'temp_del = 0 AND prospect_id = '.$data['id']);
                                                    
                                                    if($exist == $_data['id']) {

                                                        echo '<option '.($_data['prospect_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';

                                                    }

                                                    if(!$exist) {

                                                        echo '<option '.($_data['prospect_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';

                                                    }

												}
												?>
											</select>
                                        </div>
                                    </div>

                                    <!-- ATTACHMENT -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="attachment"><?php echo renderLang($contract_attachment); ?></label><br>
                                            <?php 
                                            if(!empty($_data['attachment'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($_data['attachment'], ',')) {

                                                    $attachments = explode(',', $_data['attachment']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/prf/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/prf/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/prf/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/prf/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/prf/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $_data['attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/prf/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control mt-1" name="attachment[]" multiple>
                                        </div>
                                    </div>
									
								</div><!-- row -->

                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th><?php echo renderLang($prf_name); ?></th>
                                                    <th><?php echo renderLang($prf_department); ?></th>
                                                    <th><?php echo renderLang($prf_job_title); ?></th>
                                                    <th><?php echo renderLang($prf_number_of_staff); ?></th>
                                                    <th><?php echo renderLang($lang_status); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-data">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM prf_departments WHERE prf_id = :id");
                                                $sql->bindParam(":id", $id);
                                                $sql->execute();
                                                $last_code = '';
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';

                                                        echo '<td class="p-0">';
                                                            echo '<input type="text" class="form-control border-0" name="prf_name[]" value="'.$data['name'].'">';
                                                        echo '</td>';

                                                        echo '<td class="p-0">';
                                                            echo '<input type="text" class="form-control border-0" name="department[]" value="'.$data['department'].'">';
                                                        echo '</td>';

                                                        // job title
                                                        echo '<td class="p-0">';
                                                            echo '<select class="form-control border-0" name="job-title[]">';
                                                            $sql1 = $pdo->prepare("SELECT * FROM positions_for_project");
                                                            $sql1->execute();
                                                            while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                echo '<option '.($data['job_title'] == $data1['id'] ? 'selected' : '').' value="'.$data1['id'].'">'.$data1['position'].'</option>';
                                                            }
                                                            echo '</select>';
                                                        echo '</td>';

                                                        echo '<td class="p-0">';
                                                            echo '<input type="text" class="form-control border-0" name="number-of-staff[]" value="'.$data['number_of_staff'].'">';
                                                        echo '</td>';
                                                        echo '<td class="p-0">';
                                                            echo '<select name="status[]" class="form-control border-0">';
                                                            foreach($prf_status_arr as $key => $value) {
                                                                echo '<option '.($data['status'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                                            }
                                                            echo '</select>';
                                                        echo '</td>';
                                                        echo '<input type="hidden" name="code[]" value="'.$data['id'].'">';

                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                            <tr class="default-row d-none" data-code="<?php echo $last_code; ?>">
                                                <td class="p-0"><input type="text" class="form-control border-0" name="prf_name[]"></td>
                                                <td class="p-0"><input type="text" class="form-control border-0" name="department[]"></td>
                                                <td class="p-0">
                                                    <select class="form-control border-0" name="job-title[]">
                                                    <?php 
                                                    $sql1 = $pdo->prepare("SELECT * FROM positions_for_project");
                                                    $sql1->execute();
                                                    while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data1['id'].'">'.$data1['position'].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td class="p-0"><input type="text" class="form-control border-0" name="number-of-staff[]"></td>
                                                <td class="p-0">
                                                    <select name="status[]" class="form-control border-0">
                                                    <?php 
                                                        foreach($prf_status_arr as $key => $value) {
                                                            echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="text-right">
                                            <button href="" class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                        </div>
                                    </div>
                                </div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/prf-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($prf_update); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- confirm delete -->
        <?php if(checkPermission('prf-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-prf" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($prf_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($prf_modal_delete_msg2); ?></p>
                            <hr>
                            <div class="form-group is-invalid">
                                <label for="modal_confirm_delete_upass"><?php echo renderLang($enter_password); ?></label>
                                <input type="password" class="form-control required" id="modal_confirm_delete_upass" name="upass" placeholder="<?php echo renderLang($enter_password_placeholder); ?>" required>
                            </div>
                            <div class="modal-error alert alert-danger"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
                            <button class="btn btn-danger btn-delete"><i class="fa fa-check mr-2"></i><?php echo renderLang($modal_confirm_delete); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- modal -->
        <?php } ?>

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script>
		$(function() {
            var code = $('.default-row').data('code');
            $('.add-row').on('click', function(e){
                e.preventDefault();

                var fields = '<tr>'+$('.default-row').html()+'<input type="hidden" name="code[]" value="0"></tr>';
                $('.table-data').append(fields);

            });

			// open delete modal
            $('#delete').on('click', function(e){
                e.preventDefault();
                $('#modal-confirm-delete .modal-error').hide();
                $('#modal-confirm-delete').modal('show');
            });

            // submit delete modal
            $('form.ajax-form').on('submit', function(e){
                e.preventDefault();
                var post_url = $(this).attr('action');
                $.ajax({
                    url: post_url,
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response){
                        var response_arr = response.split(',');
                        if(response_arr[0] == 1) { // val is 1
                            window.location.href = '/prf-list';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
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