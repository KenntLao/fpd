<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('minutes-of-meeting')) {

		// set page
		$page = 'minutes-of-meeting';

		
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
	<title><?php echo renderLang($minutes_of_meeting); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="far fa-file-alt mr-3"></i><?php echo renderLang($minutes_of_meeting); ?></h1>
						</div>
					</div> 
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php
					renderSuccess('sys_mom_edit_suc');
					renderSuccess('sys_mom_add_suc');
					renderError('sys_mom_add_err');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($mom_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('minutes-of-meeting-add')) { ?><a href="/add-minutes-of-meeting" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($mom_new_minutes_of_meeting); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<?php if (checkPermission('minutes-of-meeting-properties')) {?>
											<th>Properties</th>
											<?php } ?>
											<?php if (checkPermission('minutes-of-meeting-departments')) {?>
											<th>Departments</th>
											<?php } ?>
											<th><?php echo renderLang($mom_subject); ?></th>
											<th><?php echo renderLang($mom_venue); ?></th>
											<th><?php echo renderLang($mom_attachment); ?></th>
											<th><?php echo renderLang($mom_date); ?></th>
											<th><?php echo renderLang($mom_time_from); ?></th>
											<th><?php echo renderLang($mom_time_to); ?></th>
											<?php if (checkPermission('minutes-of-meeting')) { ?>
											<th class="w35"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php 

										$sql = $pdo->prepare("SELECT mom.id, mom.attachment, p.property_id, p.property_name, department_name, department_code, mom.subject, mom.venue, mom.time_from, mom.time_to, mom.date_reserve FROM minutes_of_meetings mom LEFT JOIN properties p ON (mom.property_id = p.id) LEFT JOIN departments d ON (mom.department_id = d.id) WHERE mom.temp_del = 0  ORDER BY mom.id ASC");
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$id = $data['id'];

											echo'<tr>';

											if (checkPermission('minutes-of-meeting-properties')) {
											echo '<td>['.$data['property_id'].'] '.$data['property_name'].'</td>';
											}
											if (checkPermission('minutes-of-meeting-departments')) {
											echo '<td>['.$data['department_code'].'] '.$data['department_name'].'</td>';
											}
											echo '<td>'.$data['subject'].'</td>';
											echo '<td>'.$data['venue'].'</td>';
											// ATTACHMENT
                                                echo '<td>';
                                                if(!empty($data['attachment'])) {

                                                    $img_ext = array('jpg', 'jpeg', 'png');
                                                    if(strpos($data['attachment'], ',')) {

                                                        $attachments = explode(',', $data['attachment']);
                                                        foreach($attachments as $attachment) {

                                                            $attachment_part = explode('.', $attachment);
                                                            
                                                            if(in_array($attachment_part[1], $img_ext)) {

                                                                
                                                                    echo '<a href="/assets/uploads/minutes_of_meeting/'.$attachment.'" data-toggle="lightbox">'; 
                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/minutes_of_meeting/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                        echo $attachment;
                                                                    echo '</a><br>';
                                                                

                                                            } else {

                                                                echo '<a href="/assets/uploads/minutes_of_meeting/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                            }

                                                        }

                                                    } else {

                                                        $attachment_part = explode('.', $data['attachment']);
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                                
                                                            echo '<a href="/assets/uploads/minutes_of_meeting/'.$data['attachment'].'" data-toggle="lightbox">'; 
                                                                echo '<img class="has-bg-img mr-2" src="/assets/uploads/minutes_of_meeting/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                echo $data['attachment'];
                                                            echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/minutes_of_meeting/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';

                                                        }
                                                    
                                                    }

                                                }
                                                echo '</td>';
											echo '<td>'.formatDate($data['date_reserve']).'</td>';
											echo '<td>'.$data['time_from'].'</td>';
											echo '<td>'.$data['time_to'].'</td>';
											
											if(checkPermission('minutes-of-meeting')) {

												echo '<td><a href="/edit-minutes-of-meeting/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($minutes_of_meeting_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';
												}

											echo'</tr>';


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

    <div class="modal fade" id="modal-print">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title"><?php echo renderLang($notice_to_proceed_print_form); ?></h4>
                </div>
                <form action="/delete-notice-to-proceed" method="post" class="ajax-form">
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
                        <button class="btn btn-primary btn-delete"><i class="fa fa-print mr-2"></i><?php echo renderLang($lang_print); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	
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