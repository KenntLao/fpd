<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('daily-collections')) {

  	$page = 'collections';

  	$id = $_GET['id'];

  	// suggested client ID
        $sql = $pdo->prepare("SELECT dc.id, u.unit_name, dc.unit_id, sp.sub_property_name, p.property_name, dc.voucher_type, collection_date,  dc.attachment FROM daily_collections dc LEFT JOIN units u ON (dc.unit_id = u.id) LEFT JOIN sub_properties sp ON (dc.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE dc.id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($daily_collections_daily_collection); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-tasks mr-3"></i><?php echo renderLang($daily_collections_daily_collection); ?>
							<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $data['sub_property_name'].' ['.$data['property_name'].']'; ?>
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
			        			<h3 class="card-title"><?php echo renderLang($daily_collections_details); ?></h3>
                                <div class="card-tools">
                                    <?php if(checkPermission('daily-collection-edit')) { ?>
                                        <a href="/edit-daily-collection/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-pencil-alt mr-1"></i><?php echo renderLang($daily_collections_edit_daily_collection); ?></a>
                                    <?php } ?>
                                </div>
			        		</div>
			        		<div class="card-body">

			        			<div class="table-responsive">
	                                	<table class="table table-bordered">
	                                        <tr>
	                                            <th class="w300"><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
	                                            <td><?php echo $data['sub_property_name']; ?>[ <?php echo $data['property_name']; ?> ]</td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($daily_collections_daily_collection_voucher_type); ?></th>
	                                            <td><?php echo renderLang($reference_number_arr[$data['voucher_type']]); ?></td>
	                                        </tr>
	                                        <tr>
	                                            <th><?php echo renderLang($daily_collections_daily_collection_unit); ?></th>
	                                            <td><?php echo $data['unit_id']; ?></td>
	                                        </tr>

	                                		<?php 
		                                		$sql1 = $pdo->prepare("SELECT * FROM daily_collections_payment_types WHERE daily_collection_id = :id");
		                                		$sql1->bindParam(":id", $id); 
		                                		$sql1->execute();
		                                		$payment_types = array();
                                                $amounts = array();
                                                $banks = array();
                                                $other_banks = array();
                                                $check_numbers = array();
                                                while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                    $payment_types[] = $data1['payment_type'];
                                                    $amounts[] = $data1['amount'];
                                                    $banks[] = $data1['bank'];
                                                    $other_banks[] = $data1['other_bank'];
                                                    $check_numbers[] = $data1['check_number'];
                                                }?>

			                                        <tr>
			                                            <th><?php echo renderLang($daily_collections_daily_collection_payment_type); ?></th>
			                                            <td><?php 
			                                            foreach($payment_types as $payment_type) {
	                                                        echo '<li>'.renderLang($payment_types_arr[$payment_type]).'</li>';
	                                                    } ?>
	                                                    </td>
			                                        </tr>
			                                        <tr>
			                                            <th><?php echo renderLang($daily_collections_daily_collection_amount); ?></th>
			                                            <td>
			                                            <?php foreach($amounts as $amount) {
		                                                        echo '<li>'.$amount.'</li>'; } ?>
	                                                    </td>
			                                        </tr>
													<tr>
														<th><?php echo renderLang($collections_check_voucher_check_number); ?></th>
														<td><?php foreach($check_numbers as $check_number) {
		                                                        echo '<li>'.$check_number.'</li>'; } ?>
                                                    	</td>
													</tr>
			                                        <tr>
			                                            <th><?php echo renderLang($collections_check_voucher_bank); ?></th>
														<td>
														<?php 
														foreach($banks as $key => $bank) {

	                                                    	if ($bank == '999') {
	                                                    		echo '<li>'.$other_banks[$key].'</li>';
	                                                    	}else{

	                                                    		echo '<li>'.(checkVar($bank) ? renderLang($banks_arr[$bank]) : '').'</li>';

	                                                    	}
	                                                        
	                                                    }
														?>
														</td>
			                                        </tr> 

	                                        <tr>
	                                            <th><?php echo renderLang($daily_collections_daily_collection_date); ?></th>
	                                            <td><?php echo  formatDate($data['collection_date']); ?></td>
	                                        </tr>
											<tr>
												<th><?php echo renderLang($move_inout_requests_attachment); ?></th>
												<td>
												<?php 
												if(!empty($data['attachment'])) {

													$img_ext = array('jpg', 'jpeg', 'png');
													if(strpos($data['attachment'], ',')) {
	
														$attachments = explode(',', $data['attachment']);
														foreach($attachments as $attachment) {
	
															$attachment_part = explode('.', $attachment);
															
															if(in_array($attachment_part[1], $img_ext)) {
	
																
																	echo '<a href="/assets/uploads/daily-collection/'.$attachment.'" data-toggle="lightbox">'; 
																		echo '<img class="has-bg-img mr-2" src="/assets/uploads/daily-collection/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																		echo $attachment;
																	echo '</a><br>';
																
	
															} else {
	
																echo '<a href="/assets/uploads/daily-collection/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';
	
															}
	
														}
	
													} else {
	
														$attachment_part = explode('.', $data['attachment']);
														if(in_array($attachment_part[1], $img_ext)) {
	
																
															echo '<a href="/assets/uploads/daily-collection/'.$data['attachment'].'" data-toggle="lightbox">'; 
																echo '<img class="has-bg-img mr-2" src="/assets/uploads/daily-collection/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																echo $data['attachment'];
															echo '</a><br>';
															
	
														} else {
	
															echo '<a href="/assets/uploads/daily-collection/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';
	
														}
													
													}
	
												}
												?>
												</td>
											</tr>                  	
	                                    </table>
	                            	</div>

							</div>
			        		<div class="card-footer text-right">
			        			<a href="/daily-collections/1" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
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
		$(function() {

            $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            var building_id = $('#building').val();

            $.post('/daily-collection-unit-options', {
                id:building_id
            }, function(data){
                $('#unit').html(data);
            });


            $('#building').on('change', function(){

                building_id = $(this).val();

                $.post('/daily-collection-unit-options', {
                    id:building_id
                }, function(data){
                    $('#unit').html(data);
                });

            });

			$('#date1').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});

	     	$('#date2').daterangepicker({
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