<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('doc-contract-edit')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
    $page = 'contracts';
    
    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT * FROM document_management_contracts WHERE id = :id AND temp_del = 0 LIMIT 1");
    $sql->bindParam(":id", $id);
    $sql->execute();
    $sub_property_id = 0;
    if($sql->rowCount()) {
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        $sub_property_id = $_data['sub_property_id'];
    } else {

        $_SESSION['sys_doc_contracts_err'] = renderLang($lang_no_data);
        header('location: /doc-contract-list/'.$id);
        exit();

    }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($contract_edit_contract); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	
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
							<h1>
                                <i class="fas fa-file-contract mr-3"></i><?php echo renderLang($contract_edit_contract); ?>
                                <span class="fa fa-chevron-right ml-2 mr-2"></span>
                                <?php echo $_data['contractor']; ?>
                            </h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_doc_contract_add_err');
                    ?>

                    <form action="/submit-add-doc-contract" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($contract_edit_contract_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="id" value="<?php echo $_data['id']; ?>">

                                <div class="row">

                                    <!-- Name of contractor -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="name_of_contractor"><?php echo renderLang($contracts_name_of_contractor); ?></label>
                                            <input type="text" name="name_of_contractor" id="name_of_contractor" class="form-control" value="<?php echo $_data['contractor']; ?>">
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="address"><?php echo renderLang($contracts_address); ?></label>
                                            <input type="text" name="address" id="address" class="form-control" value="<?php echo $_data['address']; ?>">
                                        </div>
                                    </div>

                                    <!-- Type of services -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="type_of_service"><?php echo renderLang($contracts_type_of_services); ?></label>
                                            <select name="type_of_service" id="type_of_service" class="form-control">
                                                <?php 
                                                foreach($contract_type_of_services_arr as $key => $services) {
                                                    echo '<option '.($_data['type_of_service'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($services).'</option>';
                                                }
                                                ?>
                                            </select>
                                            <div class="mt-1 specify<?php echo $_data['type_of_service'] == 7 ? '' : ' d-none' ?>">
                                                <label for="type_of_service_specify"><?php echo renderLang($contracts_specify); ?></label>
                                                <input type="text" name="type_of_service_specify" id="type_of_service_specify" class="form-control" value="<?php echo $_data['type_of_service_specify']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                
                                    <!-- Contact person -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="contact_person"><?php echo renderLang($contracts_contact_person); ?></label>
                                            <input type="text" name="contact_person" id="contact_person" class="form-control" value="<?php echo $_data['contact_person']; ?>">
                                        </div>
                                    </div>

                                    <!-- Contact number -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="contact_number"><?php echo renderLang($contracts_contact_number); ?></label>
                                            <input type="text" name="contact_number" id="contact_number" class="form-control" value="<?php echo $_data['contact_number']; ?>">
                                        </div>
                                    </div>

                                    <!-- Date of accreditation -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="accreditation"><?php echo renderLang($contracts_date_of_accreditation); ?></label>
                                            <input type="text" name="accreditation" id="accreditation" class="form-control date" value="<?php echo formatDate($_data['accreditation_date']); ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                                
                                    <!-- Term beginning -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="term_beginning"><?php echo renderLang($contracts_term_beginning); ?></label>
                                            <input type="text" name="term_beginning" id="term_beginning" class="form-control date" value="<?php echo formatDate($_data['term_beginning_date']); ?>">
                                        </div>
                                    </div>

                                    <!-- Term Ended -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="term_ended"><?php echo renderLang($contracts_term_ended); ?></label>
                                            <input type="text" name="term_ended" id="term_ended" class="form-control date" value="<?php echo formatDate($_data['term_ended_date']); ?>">
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/doc-contract-list/<?php echo $sub_property_id; ?>" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-success"><i class="fa fa-save mr-1"></i><?php echo renderLang($contract_update_contract); ?></button>
                            </div>
                        </div>

                    </form>

                </div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
    $(function(){

        // datepicker
        $('.date').each(function(){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

        // show specify field if othes is selected
        $('#type_of_service').on('change', function(){

            var val = $(this).val();

            if(val == 7) {
                $('.specify').removeClass('d-none');
            } else {
                $('.specify').addClass('d-none');
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