<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-bdd-edit')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'proposal';

		if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {

            $id = $_GET['id'];

            $sql = $pdo->prepare("SELECT pil.*, p.project_name as pName, p.reference_number as refNum FROM proposal_introductory_letters pil INNER JOIN prospecting p ON pil.prospect_id = p.id WHERE pil.id = :id AND pil.temp_del = 0");
            $sql->bindParam(":id" ,$id);
            $sql->execute();
            if ($sql->rowCount()==1) {
                $_data = $sql->fetch(PDO::FETCH_ASSOC);
            } else {
                // and show message that the letter is not found
                header("Location: /bdmd-introductory-letters-list");
            }
        } else {
            // and show message that the letter is not found
		    header("Location: /bdmd-introductory-letters-list");
        }
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($add_proposal_bdd); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>

    <style>
    th {
        text-align: center;
    }
    </style>
	
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
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($edit_proposal_bdd); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
                    <form action="/submit-add-bdd-introductory-letter-proposal" method="post">
                        <input type="hidden" name="id" value="<?= $id?>">
                        <input type="hidden" name="proposal_category" value="bdd">
                        
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($proposals_introductory_letter_form); ?></h3>
                            </div>
                            <div class="card-body">

    							<div class="row mb-4 ml-5 pl-2">

                                    <!-- PROJECT NAME -->
                                    <div class="col-lg-3 col-md-4 ml-5">
                                        <input type="hidden" id="prospect_id" name="prospect_id" value="<?= $_data['prospect_id'] ?>">
                                        <div class="form-group ml-5">
                                            <label for="prospect_id" ><?php echo renderLang($notice_to_proceed_project_name); ?></label>
                                            <input type="text" class="form-control disabled" disabled value="<?= "[".$_data['refNum']."] ".$_data['pName'] ?>" >
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">

                                    <div class="col-lg-9 col-md-12 mx-auto">

                                        <p><?php echo renderLang($proposals_introductory_letter_dear); ?><input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom" name="dear_name" value="<?= $_data['dear_name']?>"></p>
                                        <p><?php echo renderLang($proposals_introductory_letter_greetings); ?></p>

                                        <p class="text-left">
                                            <?php echo renderLang($proposals_introductory_letter1); ?>
                                            <input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom" name="services" value="<?= $_data['services'] ?>">
                                        </p>

                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter2); ?></p>
                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter3); ?></p>
                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter4); ?></p>

                                        <div class="col-md-6 col-sm-12 mx-auto">

                                            <!-- NAME -->
                                            <p><?php echo renderLang($proposals_introductory_letter_name); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w300" name="contact_name" value="<?= $_data['contact_name'] ?>"></p>

                                            <!-- POSITON -->
                                            <p><?php echo renderLang($proposals_introductory_letter_position); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w300" name="position" value="<?= $_data['position'] ?>"></p>

                                            <!-- TRUNK LINE NO. -->
                                            <p><?php echo renderLang($proposals_introductory_letter_trunkline_no); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w250" name="trunkline_no" value="<?= $_data['trunkline_no'] ?>"></p>

                                            <!-- FAX NO. -->
                                            <p><?php echo renderLang($proposals_introductory_letter_fax_no); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w300" name="fax_no" value="<?= $_data['fax_no'] ?>"></p>

                                            <!-- FAX NO. -->
                                            <p><?php echo renderLang($proposals_introductory_letter_email); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w300" name="email" value="<?= $_data['email'] ?>"></p>
                                            
                                        </div>

                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter5); ?></p>
                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter6); ?></p>

                                        <br>

                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter_truly_yours); ?></p>

                                        <br>

                                        <div class="col-md-4">
                                            <input type="" class="ml-1 mr-1 px-2 certify-border border-bottom form-control" name="sender" value="<?= $_data['sender'] ?>">
                                            <p>Director</p>
                                            <p>Business Development and Marketing</p>
                                        </div>

                                        
                                    </div>

    							</div><!-- row -->

                            </div><!-- card body -->
                            <div class="card-footer text-right">
                                <a href="/bdmd-introductory-letters-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($update_proposal_bdd); ?></button>
                            </div>
                        </div><!-- card -->

                    </form>

                </div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	
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