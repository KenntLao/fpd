<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-bdd-add')) {
	
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
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($add_proposal_bdd); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
                    <form action="/submit-add-bdd-introductory-letter-proposal" method="post">

                        <input type="hidden" name="proposal_category" value="bdd">
                        
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($proposals_introductory_letter_form); ?></h3>
                            </div>
                            <div class="card-body">

    							<div class="row mb-4">

                                    <!-- PROJECT NAME -->
                                    <div class="col-lg-3 col-md-4 mx-auto">
                                        <div class="form-group">
                                            <label for="prospect_id" ><?php echo renderLang($notice_to_proceed_project_name); ?></label>
                                            <select class="form-control select2" id="prospect_id" name="prospect_id" required>
                                                <?php
                                                $select_val = 0;
                                                if(isset($_SESSION['sys_properties_add_client_id_val'])) {
                                                    $select_val = $_SESSION['sys_properties_add_client_id_val'];
                                                }
                                                $sql = $pdo->prepare("SELECT * FROM prospecting WHERE temp_del = 0 AND prospecting_category = 0 ORDER BY project_name ASC");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    // check if already created
                                                    $exist = getField('id', 'notice_to_proceed', 'temp_del = 0 AND prospect_id = '.$data['id']);
                                                    if(!$exist) {

                                                        echo '<option value="'.$data['id'].'"';
                                                        if($select_val == $data['id']) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>['.$data['reference_number'].'] '.$data['project_name'].'</option>';

                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">

                                    <div class="col-lg-9 col-md-12 mx-auto">

                                        <p><?php echo renderLang($proposals_introductory_letter_dear); ?><input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom" name="dear_name"></p>
                                        <p><?php echo renderLang($proposals_introductory_letter_greetings); ?></p>

                                        <p class="text-left">
                                            <?php echo renderLang($proposals_introductory_letter1); ?>
                                            <input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom" name="services">
                                        </p>

                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter2); ?></p>
                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter3); ?></p>
                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter4); ?></p>

                                        <div class="col-md-6 col-sm-12 mx-auto">

                                            <!-- NAME -->
                                            <p><?php echo renderLang($proposals_introductory_letter_name); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w300" name="contact_name" value="Fernando P.Posadas"></p>

                                            <!-- POSITON -->
                                            <p><?php echo renderLang($proposals_introductory_letter_position); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w300" name="position" value="Director for Business Development"></p>

                                            <!-- TRUNK LINE NO. -->
                                            <p><?php echo renderLang($proposals_introductory_letter_trunkline_no); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w250" name="trunkline_no" value="(632) 815-3737 local 3868"></p>

                                            <!-- FAX NO. -->
                                            <p><?php echo renderLang($proposals_introductory_letter_fax_no); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w300" name="fax_no" value="(632) 815-2915"></p>

                                            <!-- FAX NO. -->
                                            <p><?php echo renderLang($proposals_introductory_letter_email); ?>
                                                <input type="text" class="ml-1 mr-1 px-2 certify-border border-bottom w300" name="email" value="lcorquillas@fpdasia.net"></p>
                                            
                                        </div>

                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter5); ?></p>
                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter6); ?></p>

                                        <br>

                                        <p class="text-left text-justify"><?php echo renderLang($proposals_introductory_letter_truly_yours); ?></p>

                                        <br>

                                        <div class="col-md-4">
                                            <input type="" class="ml-1 mr-1 px-2 certify-border border-bottom form-control" name="sender">
                                            <p>Director</p>
                                            <p>Business Development and Marketing</p>
                                        </div>

                                        
                                    </div>

    							</div><!-- row -->

                            </div><!-- card body -->
                            <div class="card-footer text-right">
                                <a href="/bdmd-proposal-types" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($add_proposal_bdd); ?></button>
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