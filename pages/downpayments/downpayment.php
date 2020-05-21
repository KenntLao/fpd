<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('billing-advice')) {

		// set page
        $page = 'billing-advice';
        
        $id = $_GET['id'];

        $sql = $pdo->prepare("SELECT project_name, reference_number, d.id, attachment, amount, d.date, d.or_num FROM downpayments d LEFT JOIN prospecting p ON(d.prospect_id = p.id) WHERE d.temp_del = 0 AND d.id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($downpayment); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1>
                                <i class="fas fa-coins mr-3"></i><?php echo renderLang($downpayment); ?>
                                <span class="fa fa-chevron-right mr-2 ml-2"></span>
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
                            <h3 class="card-title"><?php echo renderLang($downpayment_details); ?></h3>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-6 col-md-12">

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th><?php echo renderLang($downpayment_project_code); ?></th>
                                                <td><?php echo $_data['reference_number']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($downpayment_project); ?></th>
                                                <td><?php echo $_data['project_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderlang($downpayment_amount_php); ?></th>
                                                <td><?php echo $_data['amount']; ?> PHP</td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($downpayment_date); ?></th>
                                                <td><?php echo formatDate($_data['date']); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($downpayment_or); ?></th>
                                                <td><?php echo $_data['or_num']; ?></td>
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
                                                                    echo '<a href="/assets/uploads/downpayments/'.$attachment.'" data-toggle="lightbox">'; 
                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/downpayments/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                        echo $attachment;
                                                                    echo '</a>';
                                                                echo '</td>';
                                                            echo '</tr>';
                                                            

                                                        } else {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/downpayments/'.$attachment.'" target="_blank">'.$attachment.'</a>';
                                                                echo '</td>';
                                                            echo '</tr>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                        echo '<tr>';
                                                            echo '<td>';
                                                                echo '<a href="/assets/uploads/downpayments/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/downpayments/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $_data['attachment'];
                                                                echo '</a><br>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                        

                                                    } else {

                                                        echo '<tr>';
                                                            echo '<td>';
                                                                echo '<a href="/assets/uploads/downpayments/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';
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
                            
                        </div>
                        <div class="card-footer text-right">
                            <a href="/downpayments" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                            <?php if(checkPermission('billing-advice-edit')) { ?>
                            <a href="/edit-downpayment/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-pencil-alt mr-1"></i><?php echo renderLang($downpayment_edit); ?></a>
                            <?php } ?>
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

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'MMMM D, Y'
                }
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