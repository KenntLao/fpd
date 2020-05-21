<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('minutes-of-meeting-edit')) {

		// set page
		$page = 'minutes-of-meeting';

		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT department_id, m.property_id, m.date_reserve, m.time_to, m.time_from, m.venue, m.subject, m.type_of_meeting, m.attachment, m.remarks, m.order_by, m.prepared_by, m.reviewed_by, m.approved_by FROM minutes_of_meetings m WHERE m.id = :id LIMIT 1");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if ($sql->rowCount()) {

            $_data = $sql->fetch(PDO::FETCH_ASSOC);

        }else{
            $_SESSION['sys_minutes_of_meeting_edit_err'] = renderLang($lang_no_data);
            header('location: /minutes-of-meeting-list');
            exit();
        }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($minutes_of_meeting_edit); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="far fa-file-alt mr-3"></i><?php echo renderLang($minutes_of_meeting_edit); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_amenities_add_suc');
					?>
					
					<form method="post" action="/submit-edit-minutes-of-meeting" enctype="multipart/form-data">

						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($minutes_of_meeting_edit_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- PROJECT NAME -->
									<?php if (checkPermission('minutes-of-meeting-properties')) { ?>
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="property_id" ><?php echo renderLang($mom_project_name); ?></label>
											<select class="form-control select2" id="property_id" name="property_id">
												<?php
												$sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0 ORDER BY property_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'"';
													if($_data['property_id'] == $data['id']) {
														echo ' selected="selected"';
													}
													echo '>['.$data['property_id'].'] '.$data['property_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
									<?php }?>

									<?php if (checkPermission('minutes-of-meeting-departments')) { ?>
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="department_id" ><?php echo renderLang($mom_department); ?></label>
											<select class="form-control select2" id="department_id" name="department_id">
												<?php
												$sql = $pdo->prepare("SELECT * FROM departments WHERE temp_del = 0 ORDER BY department_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'"';
													if($_data['department_id'] == $data['id']) {
														echo ' selected="selected"';
													}
													echo '>['.$data['department_code'].'] '.$data['department_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
									<?php } ?>

								</div>
									
								<div class="row">

									<!-- SUBJECT -->
									<div class="col-lg-3 col-md-4">
										<label for="subject"><?php echo renderLang($mom_subject); ?></label>
										<input type="text" class="form-control" name="subject" value="<?php echo $_data['subject'] ?>" >
									</div>

									<!-- VENUE -->
									<div class="col-lg-3 col-md-4">
										<label for="venue"><?php echo renderLang($mom_venue); ?></label>
										<input type="text" class="form-control" name="venue" value="<?php echo $_data['venue']; ?>" >
									</div>


									<!-- TYPE OF MEETING -->
									<div class="col-lg-3 col-md-4">
										<label for="type_of_meeting"><?php echo renderLang($mom_type_of_meeting); ?></label>
										<input type="text" class="form-control" name="type_of_meeting" value="<?php echo $_data['type_of_meeting'] ?>">
									</div>

								</div><!-- row -->

								<div class="row">

									<!-- REMARKS -->
									<div class="col-lg-3 col-md-4">
										<label for="mom_remarks"><?php echo renderLang($mom_remarks); ?></label>
										<input type="text" class="form-control" name="mom_remarks" value="<?php echo $_data['remarks']; ?>">
									</div>

									<!-- DATE RESERVE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date_reserve"><?php echo renderLang($boardrooms_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="date_reserve" id="date_reserve" value="<?php echo $_data['date_reserve']; ?>">
											</div>
										</div>
									</div>

									<!-- TIME FROM -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_from"><?php echo renderLang($boardrooms_time_from); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="time" class="form-control float-right" name="time_from" id="time_from" value="<?php echo $_data['time_from']; ?>">
											</div>
										</div>
									</div>

									<!-- TIME TO -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_to"><?php echo renderLang($boardrooms_time_to); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="time" class="form-control float-right" name="time_to" id="time_to" value="<?php echo $_data['time_to']; ?>">
											</div>
										</div>
									</div>

									
								</div><!-- row -->

								<div class="row">

									<!-- THE MEETING WAS CALLED TO ORDER BY -->
									<div class="col-lg-4 col-md-5">
										<label for="order_by"><?php echo renderLang($mom_called_by); ?></label>
										<input type="text" class="form-control" name="order_by" value="<?php echo $_data['order_by']; ?>">
									</div>
									
								</div>

								<div class="row">

									<!-- REVIEWED BY -->
									<div class="col-lg-3 col-md-4">
										<label for="reviewed_by"><?php echo renderLang($mom_reviewed_by); ?></label>
										<input type="text" class="form-control" name="reviewed_by" value="<?php echo $_data['reviewed_by']; ?>">
									</div>

									<!-- PREPARED BY -->
									<div class="col-lg-3 col-md-4">
										<label for="prepared_by"><?php echo renderLang($mom_prepared_by); ?></label>
										<input type="text" class="form-control" name="prepared_by" value="<?php echo $_data['prepared_by']; ?>">
									</div>
									

									<!-- APPROVED BY -->
									<div class="col-lg-3 col-md-4">
										<label for="approved_by"><?php echo renderLang($mom_approved_by); ?></label>
										<input type="text" class="form-control" name="approved_by" value="<?php echo $_data['approved_by']; ?>">
									</div>

								</div>

								<br>

								<!-- REFERENCE DOCUMENTS -->
                                <h5 class="text-uppercase">attendees</h5>

								<div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo renderLang($mom_name); ?></th>
                                                            <th><?php echo renderLang($mom_position); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-data-mom-a">
                                                    	<?php 
                                                    		$sql = $pdo->prepare("SELECT * FROM mom_attendees WHERE mom_id = :id");
                                                    		$sql->bindParam(":id", $id);
                                                    		$sql->execute();
                                                    		if($sql->rowCount()) {
                                                    		while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                    			echo '<tr>';
                                                    			echo '<td><input type="text" class="form-control border-0" name="name[]" value="'.$data['name'].'"></td>';
                                                    			echo '<td><input type="text" class="form-control border-0" name="position[]" value="'.$data['position'].'"></td>';

                                                    			echo '<input type="hidden" name="attendees_id[]" value="'.$data['id'].'">';
                                                    			echo '</tr>';
                                                    			
                                                    		}
                                                    		}
                                                    	 ?>
                                                        <tr class="default-row-mom-a  d-none">

                                                            <!-- NAME -->
                                                            <td><input type="text" class="form-control border-0" name="name[]"></td>

                                                            <!-- POSITION -->
                                                            <td><input type="text" class="form-control border-0" name="position[]" ></td>

                                                            <input type="hidden" name="attendees_id[]" value="0">
                                                                
                                                                
                                                        </tr>
                                                </tbody>
                                            </table>
                                            <div class="text-right mb-3">
                                                 <button href="" class="btn btn-info add-row-mom-a"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>

								<div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo renderLang($mom_details); ?></th>
                                                            <th><?php echo renderLang($mom_action_plan_status); ?></th>
                                                            <th><?php echo renderLang($mom_responsible_party); ?></th>
                                                            <th><?php echo renderLang($mom_due_date); ?></th>
                                                            <th><?php echo renderLang($mom_remarks); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-data-mom-ap">
                                                    	<?php 
                                                    		$sql = $pdo->prepare("SELECT * FROM mom_action_plan WHERE mom_id = :id");
                                                    		$sql->bindParam(":id", $id);
                                                    		$sql->execute();
                                                    		if($sql->rowCount()) {
                                                    		while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                    			echo '<tr>';
                                                    			echo '<td><input type="text" class="form-control border-0" name="details[]" value="'.$data['details'].'"></td>';
                                                    			echo '<td><input type="text" class="form-control border-0" name="action_plan_status[]" value="'.$data['action_plan_status'].'"></td>';
                                                    			echo '<td><input type="text" class="form-control border-0" name="responsible_party[]" value="'.$data['responsible_party'].'"></td>';
                                                    			echo '<td><input type="text" class="form-control border-0 due_date" name="due_date[]" value="'.$data['due_date'].'"></td>';
                                                    			echo '<td><input type="text" class="form-control border-0" name="remarks[]" value="'.$data['remarks'].'"></td>';

                                                    			echo '<input type="hidden" name="action_plan_id[]" value="'.$data['id'].'">';
                                                    			echo '</tr>';
                                                    			
                                                    		}
                                                    		}
                                                    	 ?>
                                                        
                                                        <tr class="default-row-mom-ap d-none">

                                                            <!-- DETAILS -->
                                                            <td><input type="text" class="form-control border-0" name="details[]"></td>

                                                            <!-- ACTINON PLAN / STATUS -->
                                                            <td><input type="text" class="form-control border-0" name="action_plan_status[]"></td>

                                                            <!-- RESPONSIBLE PARTY -->
                                                            <td><input type="text" class="form-control border-0" name="responsible_party[]"></td>

                                                            <!-- DUE DATE -->
                                                            <td><input type="text" class="form-control border-0 due_date" name="due_date[]"></td>

                                                            <!-- REMARKS -->
                                                            <td><input type="text" class="form-control border-0" name="remarks[]"></td>

                                                            <input type="hidden" name="action_plan_id[]" value="0">
                                                                
                                                                
                                                        </tr>
                                                </tbody>
                                            </table>
                                            <div class="text-right mb-3">
                                                 <button href="" class="btn btn-info add-row-mom-ap"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <!-- ATTACHMENT -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="attachment"><?php echo renderLang($mom_attachment); ?></label><br>
                                            <?php 
                                            if(!empty($_data['attachment'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($_data['attachment'], ',')) {

                                                    $attachments = explode(',', $_data['attachment']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/minutes_of_meeting/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/minutes-of-meeting/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/minutes_of_meeting/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/minutes_of_meeting/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/minutes_of_meeting/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $_data['attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/minutes_of_meeting/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control mt-1" name="attachment[]" multiple>
                                        </div>
                                    </div>

                                </div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/minutes-of-meeting-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($mom_save_minutes_of_meeting); ?></button>
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
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function() {

			$('#date_reserve').daterangepicker({
				singleDatePicker: true,
		        locale: {
		            format: 'YYYY-MM-DD'
		        }
			});

			$('.add-row-mom-a').on('click', function(e){
                e.preventDefault();

                var fields = '<tr>'+$('.default-row-mom-a').html()+'</tr>';
                $('.table-data-mom-a').append(fields);

            });

            $('.add-row-mom-ap').on('click', function(e){
                e.preventDefault();

                var fields2 = '<tr>'+$('.default-row-mom-ap').html()+'</tr>';
                $('.table-data-mom-ap').append(fields2);

                $('.due_date').each(function(){
                    $(this).daterangepicker({
                        singleDatePicker: true,
		                locale: {
		                    format: 'YYYY-MM-DD'
		                }
                    });
                });

            });

            $('.due_date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
	                locale: {
	                    format: 'YYYY-MM-DD'
	                }
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