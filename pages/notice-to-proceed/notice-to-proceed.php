<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('notice-to-proceed')) {

		// set page
        $page = 'notice-to-proceed';
        
        $id = $_GET['id'];

        $sql = $pdo->prepare("SELECT ntp.id, project_name, ntp.date, ntp.status, ntp.remarks, reference_number, attachment FROM notice_to_proceed ntp LEFT JOIN prospecting p ON(ntp.prospect_id = p.id) WHERE ntp.temp_del = 0 AND ntp.id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($notice_to_proceed); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
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
							<h1>
                                <i class="fas fa-file-signature mr-3"></i><?php echo renderLang($notice_to_proceed); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['project_name']; ?>
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
                            <h3 class="card-title"><?php echo renderLang($notice_to_proceed_details); ?></h3>
                            <div class="card-tools">
                                <button class="btn<?php echo $_data['status'] == 0 ? ' btn-info' : ' btn-success'; ?>"><?php echo renderLang($notice_to_proceed_status_arr[$_data['status']]); ?></button>
                            </div>
                        </div>
                        <div class="card-body">

                        	<div class="row">

                            	<div class="col-lg-6 col-md-12">
		                            <div class="table-responsive">
		                                <table class="table table-bordered">
		                                        <tr>
		                                            <th class="w300"><?php echo renderLang($notice_to_proceed_project); ?></th>
		                                            <td>[<?php echo $_data['reference_number']; ?>] <?php echo $_data['project_name']; ?></td>
		                                        </tr>
		                                        <tr>
		                                            <th><?php echo renderLang($notice_to_proceed_date); ?></th>
		                                            <td><?php echo formatDate($_data['date']); ?></td>
		                                        </tr>
		                                        <tr>
		                                            <th><?php echo renderLang($notice_to_proceed_remarks); ?></th>
		                                            <td><?php echo $_data['remarks']; ?></td>
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
                                                                    echo '<a href="/assets/uploads/notice-to-proceeds/'.$attachment.'" data-toggle="lightbox">'; 
                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/notice-to-proceeds/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                        echo $attachment;
                                                                    echo '</a>';
                                                                echo '</td>';
                                                            echo '</tr>';
                                                            

                                                        } else {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/notice-to-proceeds/'.$attachment.'" target="_blank">'.$attachment.'</a>';
                                                                echo '</td>';
                                                            echo '</tr>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                        echo '<tr>';
                                                            echo '<td>';
                                                                echo '<a href="/assets/uploads/notice-to-proceeds/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/notice-to-proceeds/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $_data['attachment'];
                                                                echo '</a><br>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                        

                                                    } else {

                                                        echo '<tr>';
                                                            echo '<td>';
                                                                echo '<a href="/assets/uploads/notice-to-proceeds/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';
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

                        <div class="card-footer text-right">
                            <a href="/notice-to-proceed-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderlang($btn_back); ?></a>
                            <?php if(checkPermission('notice-to-proceed-edit')) { ?>
                            <a href="/edit-notice-to-proceed/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-pencil-alt mr-1"></i><?php echo renderLang($notice_to_proceed_edit_ntp); ?></a>
                            <?php } ?>
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
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<script>
		$(function() {

			$('#date-notice-to-proceed').daterangepicker({
				singleDatePicker: true
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