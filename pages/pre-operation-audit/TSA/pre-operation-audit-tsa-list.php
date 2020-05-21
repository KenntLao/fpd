<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-TSA')) {

    $page = 'pre-operation-audit';
    
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
	<title><?php echo renderLang($pre_operation_audit_tsa_list); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
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

                    <div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_tsa_list); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_pre_operation_audit_tsa_suc');
                    renderError('sys_pre_operation_audit_tsa_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($pre_operation_audit_list); ?></h3>
                            <div class="card-tools">
                                <?php if(checkPermission('pre-operation-audit-TSA-add')) { ?><a href="/add-tsa-pre-operation-audit" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($pre_operation_audit_add); ?></a><?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($pre_operation_audit_project); ?></th>
                                            <th><?php echo renderLang($pre_operation_audit_date_of_audit); ?></th>
                                            <th><?php echo renderLang($pre_operation_audit_tsa_date_presented_to_board); ?></th>
                                            <th><?php echo renderLang($pre_operation_audit_tsa_building_picture); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
                                            <?php if(checkPermission('pre-operation-audit-TSA-edit')) { ?>
                                            <th class="w35"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $sql = $pdo->prepare("SELECT p.project_name, tsa.status, tsa.id, p.reference_number, date_of_audit, date_presented, building_picture FROM pre_operation_audit_tsa tsa LEFT JOIN prospecting p ON(tsa.prospect_id =p.id) wHERE tsa.temp_del = 0");
                                    $sql->execute();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';

                                        echo '<td>';
                                        echo '<a href="/tsa-report-findings/'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</a>';
                                        echo '</td>';

                                        echo '<td>'.$data['date_of_audit'].'</td>';
                                        echo '<td>'.formatDate($data['date_presented']).'</td>';
                                        
                                        if(!empty($data['building_picture'])) {

                                            $attachment = explode('.', $data['building_picture']);
                                            $img_ext = array('jpg', 'jpeg', 'png');
                                            if(in_array($attachment[1], $img_ext)) {

                                                echo '<td>';
                                                    echo '<a href="/assets/uploads/pre-operation-audit/'.$data['building_picture'].'" data-toggle="lightbox">'; 
                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/pre-operation-audit/'.$data['building_picture'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                        echo $data['building_picture'];
                                                    echo '</a>';
                                                echo '</td>';

                                            } else {

                                                echo '<td>';
                                                echo '<a href="/assets/uploads/pre-operation-audit/'.$data['building_picture'].'" target="_blank">'.$data['building_picture'].'</a>';
                                                echo '</td>';

                                            }

                                        } else {
                                            echo '<td></td>';
                                        }

                                        echo '<td><span class="badge badge-'.$audit_status_color_arr[$data['status']].'">'.renderLang($audit_status_arr[$data['status']]).'</span></td>';

                                        // EDIT
                                        if(checkPermission('pre-operation-audit-TSA-edit')) { 
                                            
                                            echo '<td><a href="/edit-tsa-pre-operation-audit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($downpayment_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';
                                            
                                        }

                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/pre-operation-audit-departments" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<script>
		$(function(){

            $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

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