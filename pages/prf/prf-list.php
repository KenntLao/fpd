<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('prf')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'prf';
		
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
	<title><?php echo renderLang($prf); ?> &middot; <?php echo $sitename; ?></title>
	
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

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-people-carry mr-3"></i><?php echo renderLang($prf); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_prf_add_suc');
					renderError('sys_prf_add_err');
					renderSuccess('sys_prf_edit_suc');
					renderSuccess('sys_prf_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($prf_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('prf-add')) { ?><a href="/add-prf" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($prf_new_prf); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

							<?php //require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($prf_project); ?></th>
											<th><?php echo renderLang($prf_department); ?></th>
											<th><?php echo renderLang($prf_number_of_staff); ?></th>
											<th><?php echo renderLang($prf_job_title); ?></th>
											<th><?php echo renderLang($downpayment_attachment); ?></th>
											<th><?php echo renderLang($contract_status); ?></th>
											<?php if(checkPermission('prf-edit')) { ?>
											<th class="w35"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT prf.attachment, prf.id, reference_number, p.project_name FROM prf JOIN prospecting p ON prf.prospect_id=p.id WHERE prf.temp_del = 0 ORDER BY prf.prospect_id ASC");
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$data_count++;
											$id = $data['id'];

											echo '<tr>';

												// PROJECT ID
                                                echo '<td><a href="/prf/'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</a></td>';
                                                
                                                $sql1 = $pdo->prepare("SELECT * FROM prf_departments WHERE prf_id = :id");
                                                $sql1->bindParam(":id", $id);
                                                $sql1->execute();
                                                $departments = array();
                                                $number_of_staff = array();
                                                $job_title = array();
                                                $status = array();
                                                while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                    $departments[] = $data1['department'];
                                                    $number_of_staff[] = $data1['number_of_staff'];
                                                    $job_title[] = $data1['job_title'];
                                                    $status[] = $data1['status'];
                                                }

												// DEPARTMENT
                                                echo '<td>';
                                                    foreach($departments as $dept) {
                                                        echo $dept.'<br>';
                                                    }
                                                echo '</td>';

												// NUMBER OF STAFF
												echo '<td>';
                                                    foreach($number_of_staff as $staff) {
                                                        echo $staff.'<br>';
                                                    }
                                                echo '</td>';

												// JOB_TITLE
												echo '<td>';
                                                    foreach($job_title as $job) {
                                                        echo isset($job) ? getField('position', 'positions_for_project', 'id = "'.$job.'"'): '';
                                                        echo '<br>';
                                                    }
                                                echo '</td>';

                                                // ATTACHMENT
                                                echo '<td>';
                                                if(!empty($data['attachment'])) {

                                                    $img_ext = array('jpg', 'jpeg', 'png');
                                                    if(strpos($data['attachment'], ',')) {

                                                        $attachments = explode(',', $data['attachment']);
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

                                                        $attachment_part = explode('.', $data['attachment']);
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                                
                                                            echo '<a href="/assets/uploads/prf/'.$data['attachment'].'" data-toggle="lightbox">'; 
                                                                echo '<img class="has-bg-img mr-2" src="/assets/uploads/prf/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                echo $data['attachment'];
                                                            echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/prf/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';

                                                        }
                                                    
                                                    }

                                                }
                                                echo '</td>';

                                               // STATUS
                                                echo '<td>';
                                                    foreach($status as $stat) {
                                                        echo '<span class="badge'.$btn_prf_status_arr[$stat].'">'.renderLang($prf_status_arr[$stat]).'</span><br>';
                                                    }
                                                echo '</td>';

                                                if(checkPermission('prf-edit')) {

												echo '<td><a href="/edit-prf/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($contract_edit_contract).'"><i class="fa fa-pencil-alt"></i></a></td>';
												}

											echo '</tr>';
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