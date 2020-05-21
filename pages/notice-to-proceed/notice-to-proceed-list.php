<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('notice-to-proceed')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'notice-to-proceed';
		
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
	<title><?php echo renderLang($notice_to_proceed); ?> &middot; <?php echo $sitename; ?></title>
	
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

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-file-signature mr-3"></i><?php echo renderLang($notice_to_proceed); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
                    renderSuccess('sys_notice_to_proceed_add_suc');
                    renderError('sys_notice_to_proceed_add_err');
                    renderSuccess('sys_notice_to_proceed_suc');
                    renderSuccess('sys_nni_add_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($notice_to_proceed_list); ?></h3>
                            <div class="card-tools">
                            	
								<?php if(checkPermission('notice-to-proceed-add')) { ?><a href="/add-notice-to-proceed" class="btn btn-danger btn-md"><i class="fa fa-plus mr-1"></i><?php echo renderLang($notice_to_proceed_new_ntp); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

                        	<?php // require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-notice-to-proceed.php'); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($notice_to_proceed_project); ?></th>
											<th><?php echo renderLang($notice_to_proceed_date); ?></th>
											<th><?php echo renderLang($notice_to_proceed_attachment); ?></th>
											<th><?php echo renderLang($notice_to_proceed_remarks); ?></th>
											<th><?php echo renderLang($notice_to_proceed_status); ?></th>
											<?php if(checkPermission('notice-to-proceed-edit')) { ?>
											<th class="w35"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT ntp.id, p.reference_number, p.project_name, ntp.date, ntp.remarks, ntp.status, ntp.attachment FROM notice_to_proceed ntp JOIN prospecting p ON ntp.prospect_id=p.id WHERE ntp.temp_del = 0 ORDER BY ntp.prospect_id ASC");
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											if($data['status'] == 0) {

												$data_count++;
												$id = $data['id'];

												echo '<tr>';

													// PROJECT ID
													echo '<td><a href="/notice-to-proceed/'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</a></td>';

													// DATE
													echo '<td>'.formatDate($data['date']).'</td>';

													// ATTACHMENT
													echo '<td>';
													if(!empty($data['attachment'])) {

														$img_ext = array('jpg', 'jpeg', 'png');
														if(strpos($data['attachment'], ',')) {

															$attachments = explode(',', $data['attachment']);
															foreach($attachments as $attachment) {

																$attachment_part = explode('.', $attachment);
																
																if(in_array($attachment_part[1], $img_ext)) {

																	
																		echo '<a href="/assets/uploads/notice-to-proceeds/'.$attachment.'" data-toggle="lightbox">'; 
																			echo '<img class="has-bg-img mr-2" src="/assets/uploads/notice-to-proceeds/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																			echo $attachment;
																		echo '</a><br>';
																	

																} else {

																	echo '<a href="/assets/uploads/notice-to-proceeds/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

																}

															}

														} else {

															$attachment_part = explode('.', $data['attachment']);
															if(in_array($attachment_part[1], $img_ext)) {

																	
																echo '<a href="/assets/uploads/notice-to-proceeds/'.$data['attachment'].'" data-toggle="lightbox">'; 
																	echo '<img class="has-bg-img mr-2" src="/assets/uploads/notice-to-proceeds/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																	echo $data['attachment'];
																echo '</a><br>';
																

															} else {

																echo '<a href="/assets/uploads/notice-to-proceeds/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';

															}
														
														}

													}
													echo '</td>';

													// REMARKS
													echo '<td>'.$data['remarks'].'</td>';

													// STATUS
													echo '<td><span class="badge '.($data['status'] == 0 ? ' badge-info' : 'badge-success').'">'.renderLang($notice_to_proceed_status_arr[$data['status']]).'</span></td>';
													
													// EDIT
													if(checkPermission('notice-to-proceed-edit')) {
													echo '<td><a href="/edit-notice-to-proceed/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($notice_to_proceed_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';
													}

												echo '</tr>';

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