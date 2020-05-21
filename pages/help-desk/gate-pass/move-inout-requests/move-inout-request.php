<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('contract')) {

		// set page
		$page = 'move-inout-requests';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM move_inout_requests WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($move_inout_request); ?> &middot; <?php echo $sitename; ?></title>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($move_inout_request); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['unit']; ?>
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
								<h3 class="card-title"><?php echo renderLang($move_inout_requests_details); ?></h3>
								<div class="card-tools">
                                <button class="btn<?php echo $btn_move_inout_request_status_arr[$_data['status']]; ?>"><?php echo renderLang($move_inout_request_status_arr[$_data['status']]); ?></button>
                            	</div>
							</div>
							<div class="card-body">
								<div class="col-lg-6 col-md-12">
									<div class="table-responsive">
	                                	<table class="table table-bordered">
                                        
                                        <tr>
                                            <th><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
                                            <?php 
											$sql = $pdo->prepare("SELECT sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON (sp.property_id = p.id) WHERE sp.id = :sub_property_id");
											$sql->bindParam(":sub_property_id",$_data['sub_property_id']);
											$sql->execute();
											$_data2 = $sql->fetch(PDO::FETCH_ASSOC);
											?>
                                            <td><?php echo $_data2['sub_property_name']; ?> [<?php echo $_data2['property_name']; ?>]</td>
                                        </tr>
	                                        <tr>
	                                            <th class="w300"><?php echo renderLang($move_inout_requests_date); ?></th>
	                                            <td><?php echo formatDate($_data['date']); ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($move_inout_requests_request); ?></th>
	                                            <td><?php echo renderLang($move_inout_request_arr[$_data['request']]); ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($move_inout_requests_unit); ?></th>
	                                            <td><?php echo $_data['unit']; ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($move_inout_requests_person_material); ?></th>
	                                            <td><?php echo $_data['person_material']; ?></td>
	                                        </tr> 
	                                        <tr>
	                                            <th><?php echo renderLang($move_inout_requests_quantity); ?></th>
	                                            <td><?php echo $_data['quantity']; ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($move_inout_requests_remarks); ?></th>
	                                            <td><?php echo $_data['remarks']; ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($move_inout_requests_item_no); ?></th>
	                                            <th><?php echo renderLang($move_inout_requests_description); ?></th>
	                                        </tr>
	                                        <?php 
	                                        $sql = $pdo->prepare("SELECT * FROM move_inout_request_item WHERE move_inout_id = :id");
	                                        $sql->bindParam(":id", $id);
	                                        $sql->execute();
	                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
	                                            echo '<tr>';

	                                            echo '<td>'.$data['item_no'].'</td>';
	                                            echo '<td>'.$data['item_description'].'</td>';

	                                            echo '</tr>';
	                                        }
	                                        ?>

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
                                                                    echo '<a href="/assets/uploads/move-inout-requests/'.$attachment.'" data-toggle="lightbox">'; 
                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/move-inout-requests/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                        echo $attachment;
                                                                    echo '</a>';
                                                                echo '</td>';
                                                            echo '</tr>';
                                                            

                                                        } else {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/move-inout-requests/'.$attachment.'" target="_blank">'.$attachment.'</a>';
                                                                echo '</td>';
                                                            echo '</tr>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                        echo '<tr>';
                                                            echo '<td>';
                                                                echo '<a href="/assets/uploads/move-inout-requests/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/move-inout-requests/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $_data['attachment'];
                                                                echo '</a><br>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                        

                                                    } else {

                                                        echo '<tr>';
                                                            echo '<td>';
                                                                echo '<a href="/assets/uploads/move-inout-requests/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';
                                                            echo '</td>';
                                                        echo '</tr>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                        </table>
                                    </div>

                                </div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/move-inout-requests" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<?php if(checkPermission('move-inout-request-edit')) { ?>
								<a href="/edit-move-inout-request/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-pencil-alt mr-1"></i><?php echo renderLang($move_inout_requests_edit_move_inout_request); ?></a>
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