<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-esd-add')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'proposal';
		
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($generic_proposal_esd_add); ?> &middot; <?php echo $sitename; ?></title>
	
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
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($property_management_consulting_services_esd_add); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
                    <form method="post" action="/esd-pmcs-add-process">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($generic_proposal_esd); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="projectName">Project Name</label>
                                        <input type="text" name="projectName" class="form-control" placeholder="Project Name"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" id="date" name="date" class="form-control" placeholder="Date"/>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="salutation">Salutation</label>
                                        <input type="text" class="form-control" name="salutation" placeholder="Salutation" />
                                    </div>
                                    <div class="form-group">
                                        <label for="salutation">Letter Subject</label>
                                        <input type="text" class="form-control" name="letterSubject" placeholder="Letter Subject" />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="addressLine1">Address Line 1</label>
                                        <input type="text" class="form-control" name="addressLine1" placeholder="Address Line 1" />
                                    </div>
                                    <div class="form-group">
                                        <label for="addressLine2">Address Line 2</label>
                                        <input type="text" class="form-control" name="addressLine2" placeholder="Address Line 2" />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <img class="float-right" src="/assets/images/Company%20Logo.png" style="width: 200px;"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="servicesSubjectTo">Services Subject To</label>
                                        <input type="text" name="servicesSubjectTo" class="form-control" placeholder="Services Subject To"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="signatoryName">Signatory Name</label>
                                        <input type="text" name="signatoryName" class="form-control" placeholder="Signatory Name"/>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="signatoryPosition">Signatory Position</label>
                                        <input type="text" class="form-control" name="signatoryPosition" placeholder="Signatory Position" />
                                    </div>
                                    <div class="form-group">
                                        <label for="signatoryDepartment">Signatory Department</label>
                                        <input type="text" class="form-control" name="signatoryDepartment" placeholder="Signatory Department" />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="signatoryImage">Signatory Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="signatoryImage"
                                                   aria-describedby="signatoryImage">
                                            <label class="custom-file-label" for="signatoryImage">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3"></div>
                                <div class="col-12 terms">
                                    <div class="card term">
                                        <div class="card-header">
                                            <div class="input-group">
                                                <input type="text" class="form-control termName" placeholder="Term Name"/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Term Name</span>
                                                    <button type="button" class="btn btn-secondary btnDeleteTerm"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="input-group">
                                                <textarea class="form-control notes" placeholder="Notes"></textarea>
                                            </div>
                                            <br />
                                            <div class="subterms">
                                                <div class="input-group subterm" style="margin-bottom: 10px;">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="font-family: 'Wingdings 3'"></span>
                                                    </div>
                                                    <textarea class="form-control subterm" placeholder="Subterm details"></textarea>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-secondary btnDeleteSubterm"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-block btn-secondary btnAddNewSubterm">Add New Subterm</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-info btn-block" id="addNewTerm">Add New Term</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="/esd-generic-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right mr-1"></i><?php echo renderLang($btn_submit); ?></button>
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
    <script>
        $(document).ready(function () {
            $('#addNewTerm').click(function() {
               let newTerm = $(this).closest('.terms').find('.term:nth-child(1)').clone(true, true);
               newTerm.find('.termName').val("");
               newTerm.find(".notes").val("");
               let subTerm = 0;
               newTerm.find(".subterms").children('.subterm').each(function() {
                    if (subTerm!==0) {
                        $(this).remove();
                    }
                    subTerm+=1;
               });
               newTerm.find('.subterms').find('.subterm:nth-child(1)').val("");

               newTerm.insertBefore($(this));
            });

            $('.btnAddNewSubterm').click(function() {
               let subTerm = $(this).closest(".subterms").find('.subterm:nth-child(1)').clone(true, true);
               subTerm.insertBefore($(this));
            });

            $('.btnDeleteSubterm').click(function() {
               let subTerm = $(this).closest('.subterm');
               if ($(this).closest('.subterms').children('.subterm').length!==1) {
                   subTerm.remove();
               }
            });

            $('.btnDeleteTerm').click(function() {
                let term = $(this).closest('.term');
                if ($(this).closest('.terms').children('.term').length!==1) {
                    term.remove();
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