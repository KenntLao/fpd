<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('doc-contracts')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'contracts';
        
        $id = $_GET['id'];

        $sql = $pdo->prepare("SELECT * FROM sub_properties WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        if($sql->rowCount()) {
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
        } else {

            $_SESSION['sys_doc_contracts_err'] = renderLang($lang_no_data);
            header('location: /doc-management-contracts');
            exit();

        }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($contracts); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($contracts); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_doc_contract_add_suc');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($contract_list); ?></h3>
                            <?php if(checkPermission('doc-contract-add')) { ?>
                            <div class="card-tools">
                                <a href="/add-doc-contract/<?php echo $id; ?>" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($contract_new_contract); ?></a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="card-body">

                            <div class="table-resposive">
                                <table class="table table-bordered table-condensed table-hover" id="table-data">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($contracts_type_of_services) ?></th>
                                            <th><?php echo renderLang($contracts_name_of_contractor); ?></th>
                                            <th><?php echo renderLang($contracts_address) ?></th>
                                            <th><?php echo renderLang($contracts_contact_number) ?></th>
                                            <th><?php echo renderLang($contracts_contact_person) ?></th>
                                            <th><?php echo renderLang($contracts_date_of_accreditation) ?></th>
                                            <?php if(checkPermission('doc-contract-edit')) { ?>
                                                <th class="w35 no-sort p-0"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = $pdo->prepare("SELECT * FROM document_management_contracts WHERE sub_property_id = :id");
                                        $sql->bindParam(":id", $id);
                                        $sql->execute();
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                            echo '<tr>';

                                                // type of service
                                                echo '<td>';
                                                    if($data['type_of_service'] == 7) {
                                                        echo $data['type_of_service_specify'];
                                                    } else {
                                                        echo renderLang($contract_type_of_services_arr[$data['type_of_service']]);
                                                    }
                                                echo '</td>';
                                                // name of contractor
                                                echo '<td>'.$data['contractor'].'</td>';
                                                // address
                                                echo '<td>'.$data['address'].'</td>';
                                                // contact number
                                                echo '<td>'.$data['contact_number'].'</td>';
                                                // contact person
                                                echo '<td>'.$data['contact_person'].'</td>';
                                                // date of accreditation
                                                echo '<td>'.formatDate($data['accreditation_date']).'</td>';
                                                if(checkPermission('doc-contract-edit')) {
                                                    // Edit
                                                    echo '<td>';
                                                        echo '<a href="/edit-doc-contract/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($contract_edit_contract).'"><i class="fa fa-pencil-alt"></i></a>';
                                                    echo '</td>';
                                                }
                                            echo '</tr>';

                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

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