<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('contract-terminated')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'contract-terminated';
		
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
	<title><?php echo renderLang($contract); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($contract); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_contract_add_suc');
					renderSuccess('sys_contract_edit_suc');
					renderSuccess('sys_contract_suc');
					renderError('sys_contract_add_err');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($contract_list); ?></h3>
                        </div>
                        <div class="card-body">

                        	<?php //require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-contract.php'); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($contract_project); ?></th>
											<th><?php echo renderLang($contract_date_acquisition); ?></th>
											<th><?php echo renderLang($contract_renewal_date); ?></th>
											<th><?php echo renderLang($contract_contact_person); ?></th>
											<th><?php echo renderLang($contract_contact_number); ?></th>
											<th><?php echo renderLang($contract_attachment); ?></th>
											<th><?php echo renderLang($contract_status); ?></th>
											
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT c.id, reference_number, project_name, acquisition_date, renewal_date, contract_contact_person, contact_number, c.status, c.attachment FROM contract c LEFT JOIN prospecting p ON prospect_id=p.id WHERE c.temp_del = 0 AND c.status = 4 ORDER BY prospect_id");
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$data_count++;
											$id = $data['id'];

											echo '<tr>';

												// PROJECT ID
												echo '<td><a href="/contract-terminated/'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</a></td>';

												// ACQUISITION DATE
												echo '<td>'.formatDate($data['acquisition_date']).'</td>';

												// RENEWAL DATE
												echo '<td>'.formatDate($data['renewal_date']).'</td>';

												// CONTACT PERSON
												echo '<td>'.$data['contract_contact_person'].'</td>';

												// CONTACT NUMBER
												echo '<td>'.$data['contact_number'].'</td>';

                                                // ATTACHMENT
                                                echo '<td>';
                                                if(!empty($data['attachment'])) {

                                                    $img_ext = array('jpg', 'jpeg', 'png');
                                                    if(strpos($data['attachment'], ',')) {

                                                        $attachments = explode(',', $data['attachment']);
                                                        foreach($attachments as $attachment) {

                                                            $attachment_part = explode('.', $attachment);
                                                            
                                                            if(in_array($attachment_part[1], $img_ext)) {

                                                                
                                                                    echo '<a href="/assets/uploads/contracts/'.$attachment.'" data-toggle="lightbox">'; 
                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/contracts/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                        echo $attachment;
                                                                    echo '</a><br>';
                                                                

                                                            } else {

                                                                echo '<a href="/assets/uploads/contracts/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                            }

                                                        }

                                                    } else {

                                                        $attachment_part = explode('.', $data['attachment']);
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                                
                                                            echo '<a href="/assets/uploads/contracts/'.$data['attachment'].'" data-toggle="lightbox">'; 
                                                                echo '<img class="has-bg-img mr-2" src="/assets/uploads/contracts/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                echo $data['attachment'];
                                                            echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/contracts/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';

                                                        }
                                                    
                                                    }

                                                }
                                                echo '</td>';

												// STATUS
												echo '<td><span class="badge'.$btn_status_arr[$data['status']].'">'.renderLang($contract_status_arr[$data['status']]).'</span></td>';


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