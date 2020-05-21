<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('move-inout-requests')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'move-inout-requests';

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
	<title><?php echo renderLang($move_inout_requests); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($move_inout_requests); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_clients_err');
					renderSuccess('sys_move_inout_requests_add_suc');
					renderSuccess('sys_move_inout_requests_edit_suc');
					renderSuccess('sys_move_inout_requests_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($move_inout_requests_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('move-inout-request-add')) { ?><a href="/add-move-inout-request" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($move_inout_requests_new_move_inout_request); ?></a><?php } ?>
								</div>
                        </div>
                        <div class="card-body">

                        	<?php //require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
											<th><?php echo renderLang($move_inout_requests_date); ?></th>
											<th><?php echo renderLang($move_inout_requests_request); ?></th>
											<th><?php echo renderLang($move_inout_requests_unit); ?></th>
											<th><?php echo renderLang($move_inout_requests_person_material); ?></th>
											<th><?php echo renderLang($move_inout_requests_quantity); ?></th>
											<th><?php echo renderLang($move_inout_requests_attachment); ?></th>
											<th><?php echo renderLang($move_inout_requests_remarks); ?></th>
											<th><?php echo renderLang($move_inout_requests_status); ?></th>
											<?php if(checkPermission('move-inout-request-edit')) { ?>
											<th class="w35 no-sort p-0"></th>
											<?php } ?>
											
										</tr>
									</thead>
									<tbody>
										<?php
										if ($_SESSION['sys_account_mode'] == 'user') {

											$sql = $pdo->prepare("SELECT mi.*, sp.sub_property_name, p.property_name FROM move_inout_requests mi LEFT JOIN sub_properties sp ON (mi.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE mi.temp_del = 0 ORDER BY mi.date ASC ");
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
												$id = $data['id'];

												echo '<tr>';

													// SUB PROPERTY
													echo '<td><a href="/visitor/'.$id.'">'.(checkVar($data['sub_property_id']) ? $data['sub_property_name'].' ['.$data['property_name'].']' : '').'</a></td>';

													// date
													echo '<td>'.formatDate($data['date']).'</td>';

													// request
													echo '<td>'.renderLang($move_inout_request_arr[$data['request']]).'</td>';

													// unit
	                                                echo '<td>'.$data['unit'].'</td>';

													// person / material
													echo '<td>'.$data['person_material'].'</td>';
	                                                
													// quantity
													echo '<td>'.$data['quantity'].'</td>';

													// ATTACHMENT
	                                                echo '<td>';
	                                                if(!empty($data['attachment'])) {

	                                                    $img_ext = array('jpg', 'jpeg', 'png');
	                                                    if(strpos($data['attachment'], ',')) {

	                                                        $attachments = explode(',', $data['attachment']);
	                                                        foreach($attachments as $attachment) {

	                                                            $attachment_part = explode('.', $attachment);
	                                                            
	                                                            if(in_array($attachment_part[1], $img_ext)) {

	                                                                
	                                                                    echo '<a href="/assets/uploads/move-inout-requests/'.$attachment.'" data-toggle="lightbox">'; 
	                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/move-inout-requests/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
	                                                                        echo $attachment;
	                                                                    echo '</a><br>';
	                                                                

	                                                            } else {

	                                                                echo '<a href="/assets/uploads/move-inout-requests/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

	                                                            }

	                                                        }

	                                                    } else {

	                                                        $attachment_part = explode('.', $data['attachment']);
	                                                        if(in_array($attachment_part[1], $img_ext)) {

	                                                                
	                                                            echo '<a href="/assets/uploads/move-inout-requests/'.$data['attachment'].'" data-toggle="lightbox">'; 
	                                                                echo '<img class="has-bg-img mr-2" src="/assets/uploads/move-inout-requests/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
	                                                                echo $data['attachment'];
	                                                            echo '</a><br>';
	                                                            

	                                                        } else {

	                                                            echo '<a href="/assets/uploads/move-inout-requests/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';

	                                                        }
	                                                    
	                                                    }

	                                                }
	                                                echo '</td>';

													// remarks
													echo '<td>'.$data['remarks'].'</td>';

													// STATUS
													echo '<td>'.renderLang($move_inout_request_status_arr[$data['status']]).'</td>';

													if(checkPermission('move-inout-request-edit')) {

													echo '<td><a href="/edit-move-inout-request/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($move_inout_requests_edit_move_inout_request).'"><i class="fa fa-pencil-alt"></i></a></td>';
													}

												echo '</tr>';
											}
											
										} else {

											$sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

											$sub_properties = implode(',',$sub_property_ids);

											$sql = $pdo->prepare("SELECT mi.*, sp.sub_property_name, p.property_name FROM move_inout_requests mi LEFT JOIN sub_properties sp ON (mi.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE mi.temp_del = 0 AND mi.sub_property_id IN ($sub_properties) ORDER BY mi.date ASC ");
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
												$id = $data['id'];

												echo '<tr>';

													// SUB PROPERTY
													echo '<td><a href="/visitor/'.$id.'">'.(checkVar($data['sub_property_id']) ? $data['sub_property_name'].' ['.$data['property_name'].']' : '').'</a></td>';

													// date
													echo '<td>'.formatDate($data['date']).'</td>';

													// request
													echo '<td>'.renderLang($move_inout_request_arr[$data['request']]).'</td>';

													// unit
	                                                echo '<td>'.$data['unit'].'</td>';

													// person / material
													echo '<td>'.$data['person_material'].'</td>';
	                                                
													// quantity
													echo '<td>'.$data['quantity'].'</td>';

													// ATTACHMENT
	                                                echo '<td>';
	                                                if(!empty($data['attachment'])) {

	                                                    $img_ext = array('jpg', 'jpeg', 'png');
	                                                    if(strpos($data['attachment'], ',')) {

	                                                        $attachments = explode(',', $data['attachment']);
	                                                        foreach($attachments as $attachment) {

	                                                            $attachment_part = explode('.', $attachment);
	                                                            
	                                                            if(in_array($attachment_part[1], $img_ext)) {

	                                                                
	                                                                    echo '<a href="/assets/uploads/move-inout-requests/'.$attachment.'" data-toggle="lightbox">'; 
	                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/move-inout-requests/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
	                                                                        echo $attachment;
	                                                                    echo '</a><br>';
	                                                                

	                                                            } else {

	                                                                echo '<a href="/assets/uploads/move-inout-requests/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

	                                                            }

	                                                        }

	                                                    } else {

	                                                        $attachment_part = explode('.', $data['attachment']);
	                                                        if(in_array($attachment_part[1], $img_ext)) {

	                                                                
	                                                            echo '<a href="/assets/uploads/move-inout-requests/'.$data['attachment'].'" data-toggle="lightbox">'; 
	                                                                echo '<img class="has-bg-img mr-2" src="/assets/uploads/move-inout-requests/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
	                                                                echo $data['attachment'];
	                                                            echo '</a><br>';
	                                                            

	                                                        } else {

	                                                            echo '<a href="/assets/uploads/move-inout-requests/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';

	                                                        }
	                                                    
	                                                    }

	                                                }
	                                                echo '</td>';

													// remarks
													echo '<td>'.$data['remarks'].'</td>';

													// STATUS
													echo '<td>'.renderLang($move_inout_request_status_arr[$data['status']]).'</td>';

													if(checkPermission('move-inout-request-edit')) {

													echo '<td><a href="/edit-move-inout-request/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($move_inout_requests_edit_move_inout_request).'"><i class="fa fa-pencil-alt"></i></a></td>';
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
                "order": [[ 1, "desc" ]]
            });

            // remove sorting in column
	        $('.no-sort').each(function(){
	            $(this).removeClass('sorting');
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