<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('contract')) {

		// set page
		$page = 'contract';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM contract  WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;

        $reference_number = getField('reference_number', 'prospecting', 'id = '.$_data['prospect_id']);
        $project_name = getField('project_name', 'prospecting', 'id = '.$_data['prospect_id']);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($contract_new_contract); ?> &middot; <?php echo $sitename; ?></title>
    
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($contract); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $project_name; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($contract_details); ?></h3>
								<div class="card-tools">
                                <button class="btn<?php echo $btn_status_arr[$_data['status']]; ?>"><?php echo renderLang($contract_status_arr[$_data['status']]); ?></button>
                            	</div>
							</div>
								
							<div class="card-body">
							<div class="row">

								<div class="col-lg-6 col-md-12">
									<div class="table-responsive">
	                                	<table class="table table-bordered">
	                                        <tr>
	                                            <th class="w300"><?php echo renderLang($contract_project); ?></th>
	                                            <td>[<?php echo $reference_number; ?>] <?php echo $project_name; ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($contract_date_acquisition); ?></th>
	                                            <td><?php echo formatDate($_data['acquisition_date']); ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($contract_renewal_date); ?></th>
	                                            <td><?php echo  formatDate($_data['renewal_date']); ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($contract_contact_person); ?></th>
	                                            <td><?php echo $_data['contract_contact_person']; ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($contract_contact_number); ?></th>
	                                            <td><?php echo $_data['contact_number']; ?></td>
	                                        </tr>
                                            <tr>
                                                <th><?php echo renderLang($contract_terms_of_payment); ?></th>
                                                <td><?php echo renderLang($contract_terms_arr[$_data['term_of_payment']]); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($contract_advance_payment); ?></th>
                                                <td><?php echo $_data['advance_payment']; ?></td>
                                            </tr> 
                                            <tr>
                                                <th><?php echo renderLang($contract_number_of_month); ?></th>
                                                <td><?php echo $_data['number_of_month']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($contract_security_deposit); ?></th>
                                                <td><?php echo $_data['security_deposit']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($contract_mode_of_payment); ?></th>
                                                <td><?php echo $_data['mode_of_payment']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($contract_amount_php); ?></th>
                                                <td><?php echo $_data['amount']; ?></td>
                                            </tr>                  	
                                        </table>
	                            	</div>
								</div>
								<div class="col-lg-6 col-md-12">

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th><?php echo renderLang($contract_attachment); ?></th>
                                            </tr>
                                            <?php 
                                            if(!empty($_data['attachment'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($_data['attachment'], ',')) {

                                                    $attachments = explode(',', $_data['attachment']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/contracts/'.$attachment.'" data-toggle="lightbox">'; 
                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/contracts/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                        echo $attachment;
                                                                    echo '</a>';
                                                                echo '</td>';
                                                            echo '</tr>';
                                                            

                                                        } else {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/contracts/'.$attachment.'" target="_blank">'.$attachment.'</a>';
                                                                echo '</td>';
                                                            echo '</tr>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                        echo '<tr>';
                                                            echo '<td>';
                                                                echo '<a href="/assets/uploads/contracts/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/contracts/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $_data['attachment'];
                                                                echo '</a><br>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                        

                                                    } else {

                                                        echo '<tr>';
                                                            echo '<td>';
                                                                echo '<a href="/assets/uploads/contracts/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';
                                                            echo '</td>';
                                                        echo '</tr>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                        </table>
                                    </div>

                                </div>
								
							</div>
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/contract-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<?php if(checkPermission('contract-edit')) { ?>
								<a href="/edit-contract/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-pencil-alt mr-1"></i><?php echo renderLang($contract_edit_contract); ?></a>
								<?php } ?>
							</div>
						</div><!-- card -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script>
        $(function(){
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