<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('notice-of-new-instructions')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'notice-of-new-instructions';
		
		// set fields from table to search on
		$fields_arr = array('client_id','client_name','contact_person');
		$search_placeholder = renderLang($clients_client_id).', '.renderLang($clients_client_name).', '.renderLang($clients_contact_person);
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		$sql_query = 'SELECT * FROM clients'.$where; // set sql statement
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($notice_of_new_instruction); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-file-alt mr-3"></i><?php echo renderLang($notice_of_new_instruction); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_nni_add_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($nni_nni_list); ?></h3>
                            <div class="card-tools">
							</div>
                        </div>
                        <div class="card-body">

							<?php // require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($prospecting_project_name); ?></th>
											<th><?php echo renderLang($nni_remarks); ?></th>
                                            <th><?php echo renderLang($nni_attachment); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
											<?php if (checkPermission('notice-of-new-instruction-edit')) { ?>
											<th class="w35 p-0"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT ntp.id, nni_attachment, nni.assigned, nni.status, ntp.prospect_id, nni.remarks, p.project_name, p.reference_number FROM notice_to_proceed ntp JOIN prospecting p ON (ntp.prospect_id = p.id) LEFT JOIN nni ON (p.id = nni.prospect_id) WHERE ntp.temp_del = 0 AND ntp.status = 1 ORDER BY ntp.id ASC");
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											if($data['status'] != 4) {

												if($_SESSION['sys_account_mode'] != 'user') {

													if(checkPermission('notice-of-new-instructions-draft')) {
														
														if($data['status'] == 0) {

															$data_count++;
															$id = $data['id'];

															echo '<tr>';

																// PROJECT NAME
																echo '<td>['.$data['reference_number'].'] '.$data['project_name'].'</td>';

																// REMARKS
																echo '<td>'.$data['remarks'].'</td>';

																// NNI attachment
                                                                echo '<td>';
                                                                    renderAttachments($data['nni_attachment'], "nni");
																echo '</td>';

																echo '<td>'.(isset($data['status']) ? '<span class="badge badge-'.$nni_status_color_arr[$data['status']].'">'.renderLang($nni_status_arr[$data['status']]).'</span>' : '').'</td>';

																if (checkPermission('notice-of-new-instruction-edit')) {

																    echo '<td><a href="/edit-nni/'.$data['prospect_id'].'" class="btn btn-success btn-xs"><i class="fa fa-pencil-alt"></i></></td>';

																}
																
															echo '</tr>';

														}

													}

													if(checkPermission('notice-of-new-instructions-endorsed')) {
														
														if($data['status'] == 1) {

															$data_count++;
															$id = $data['id'];

															echo '<tr>';

																// PROJECT NAME
																echo '<td>['.$data['reference_number'].'] '.$data['project_name'].'</td>';

																// REMARKS
																echo '<td>'.$data['remarks'].'</td>';

																// NNI attachment
                                                                echo '<td>';
                                                                renderAttachments($data['nni_attachment'], "nni");
																echo '</td>';

																echo '<td>'.(isset($data['status']) ? '<span class="badge badge-'.$nni_status_color_arr[$data['status']].'">'.renderLang($nni_status_arr[$data['status']]).'</span>' : '').'</td>';

																if (checkPermission('notice-of-new-instruction-edit')) {

																    echo '<td><a href="/edit-nni/'.$data['prospect_id'].'" class="btn btn-success btn-xs"><i class="fa fa-pencil-alt"></i></></td>';

																}
																
															echo '</tr>';

														}

													}

													if(checkPermission('notice-of-new-instructions-assigned')) {
														
														if($data['status'] == 2) {

															if(checkPermission('notice-of-new-instruction-OM')) {
																
																if($data['assigned'] == $_SESSION['sys_id']) {
																	$data_count++;
																	$id = $data['id'];

																	echo '<tr>';

																		// PROJECT NAME
																		echo '<td>['.$data['reference_number'].'] '.$data['project_name'].'</td>';

																		// REMARKS
																		echo '<td>'.$data['remarks'].'</td>';

																		// NNI attachment
                                                                        echo '<td>';
                                                                        renderAttachments($data['nni_attachment'], "nni");
																		echo '</td>';

																		echo '<td>'.(isset($data['status']) ? '<span class="badge badge-'.$nni_status_color_arr[$data['status']].'">'.renderLang($nni_status_arr[$data['status']]).'</span>' : '').'</td>';

																		if (checkPermission('notice-of-new-instruction-edit')) {
																		    echo '<td><a href="/edit-nni/'.$data['prospect_id'].'" class="btn btn-success btn-xs"><i class="fa fa-pencil-alt"></i></></td>';
																		}
																		
																	echo '</tr>';
																}
															
															} else {
																
																$data_count++;
																$id = $data['id'];

																echo '<tr>';

																	// PROJECT NAME
																	echo '<td>['.$data['reference_number'].'] '.$data['project_name'].'</td>';

																	// REMARKS
																	echo '<td>'.$data['remarks'].'</td>';

																	// NNI attachment
																	echo '<td>';
																	if(!empty($data['nni_attachment'])) {

																		$img_ext = array('jpg', 'jpeg', 'png');
																		if(strpos($data['nni_attachment'], ',')) {

																			$attachments = explode(',', $data['nni_attachment']);
																			foreach($attachments as $attachment) {

																				$attachment_part = explode('.', $attachment);
																				
																				if(in_array($attachment_part[1], $img_ext)) {

																					
																						echo '<a href="/assets/uploads/nni/'.$attachment.'" data-toggle="lightbox">'; 
																							echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																							echo $attachment;
																						echo '</a><br>';
																					

																				} else {

																					echo '<a href="/assets/uploads/nni/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

																				}

																			}

																		} else {

																			$attachment_part = explode('.', $data['nni_attachment']);
																			if(in_array($attachment_part[1], $img_ext)) {

																					
																				echo '<a href="/assets/uploads/nni/'.$data['nni_attachment'].'" data-toggle="lightbox">'; 
																					echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$data['nni_attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																					echo $data['nni_attachment'];
																				echo '</a><br>';
																				

																			} else {

																				echo '<a href="/assets/uploads/nni/'.$data['nni_attachment'].'" target="_blank">'.$data['nni_attachment'].'</a><br>';

																			}
																		
																		}

																	}
																	echo '</td>';

																	echo '<td>'.(isset($data['status']) ? '<span class="badge badge-'.$nni_status_color_arr[$data['status']].'">'.renderLang($nni_status_arr[$data['status']]).'</span>' : '').'</td>';

																	if (checkPermission('notice-of-new-instruction-edit')) {

																	echo '<td><a href="/edit-nni/'.$data['prospect_id'].'" class="btn btn-success btn-xs"><i class="fa fa-pencil-alt"></i></></td>';

																	}
																	
																echo '</tr>';
															}

														}

													}

												} else { // superadmin view

													$data_count++;
													$id = $data['id'];

													echo '<tr>';

														// PROJECT NAME
														echo '<td>['.$data['reference_number'].'] '.$data['project_name'].'</td>';

														// REMARKS
														echo '<td>'.$data['remarks'].'</td>';

														// NNI attachment
														echo '<td>';
														if(!empty($data['nni_attachment'])) {

															$img_ext = array('jpg', 'jpeg', 'png');
															if(strpos($data['nni_attachment'], ',')) {

																$attachments = explode(',', $data['nni_attachment']);
																foreach($attachments as $attachment) {

																	$attachment_part = explode('.', $attachment);
																	
																	if(in_array($attachment_part[1], $img_ext)) {

																		
																			echo '<a href="/assets/uploads/nni/'.$attachment.'" data-toggle="lightbox">'; 
																				echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																				echo $attachment;
																			echo '</a><br>';
																		

																	} else {

																		echo '<a href="/assets/uploads/nni/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

																	}

																}

															} else {

																$attachment_part = explode('.', $data['nni_attachment']);
																if(in_array($attachment_part[1], $img_ext)) {

																		
																	echo '<a href="/assets/uploads/nni/'.$data['nni_attachment'].'" data-toggle="lightbox">'; 
																		echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$data['nni_attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																		echo $data['nni_attachment'];
																	echo '</a><br>';
																	

																} else {

																	echo '<a href="/assets/uploads/nni/'.$data['nni_attachment'].'" target="_blank">'.$data['nni_attachment'].'</a><br>';

																}
															
															}

														}
														echo '</td>';

														echo '<td>'.(isset($data['status']) ? '<span class="badge badge-'.$nni_status_color_arr[$data['status']].'">'.renderLang($nni_status_arr[$data['status']]).'</span>' : '').'</td>';

														if (checkPermission('notice-of-new-instruction-edit')) {

														echo '<td><a href="/edit-nni/'.$data['prospect_id'].'" class="btn btn-success btn-xs"><i class="fa fa-pencil-alt"></i></></td>';

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

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script>
    $(function(){

        $(document).on('click', '[data-toggle="lightbox"]', function(e) {
            e.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
        
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