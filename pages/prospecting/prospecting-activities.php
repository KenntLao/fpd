<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('prospecting-activity')) {

    $page = 'prospecting';
    
    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT * FROM prospecting WHERE temp_del = 0 AND id = :id LIMIT 1");
    $sql->bindParam(":id", $id);
    $sql->execute();
    $_data = $sql->fetch(PDO::FETCH_ASSOC);

	$cat = $_data['prospecting_category'];
	
	$current_date = formatDate(date('Y-m-d'));
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($prospecting_activities); ?> &middot; <?php echo $sitename; ?></title>
	
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
                                <i class="fas fa-binoculars mr-3"></i><?php echo renderLang($prospecting_activities); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <span class="text-uppercase"><?php echo renderLang($prospecting_category_arr[$cat]); ?></span>
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

                    <?php 
                    renderSuccess('sys_prospecting_activity_add_suc');
                    renderError('sys_prospecting_activity_add_err');
                    ?>

                    <form action="/save-prospecting-activity" method="post" enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($prospecting_activity_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <?php 
                                $sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE prospect_id = :id ORDER BY id ASC");
                                $sql->bindParam(":id", $id);
                                $sql->execute();
                                $is_done = array();
                                $category = '';
                                $is_done['LOI'] = '';
                                $is_done['ACT_1'] = '';
                                $is_done['ACT_2'] = '';
                                $is_done['ACT_3'] = '';

                                $act_1_count = 0;
                                $act_2_count = 0;
                                $act_3_count = 0;

                                if($sql->rowCount()) {

                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                        if($data['activity_category'] == 'LOI') {
                                            // check if LOI is done
                                            if($data['activity_type'] == 'done') {
                                                $is_done['LOI'] = $data['activity_type'];
                                                $category = 'ACT_1';
                                            } else {
                                                $is_done['LOI'] = $data['activity_type'];
                                                $category = 'LOI';
                                            }
                                        }                  
                                        
                                        if($data['activity_category'] == 'ACT_1') {
                                            // check if ACT_1 is done
                                            if($data['activity_type'] == 'done') {
                                                $is_done['ACT_1'] = $data['activity_type'];
                                                $category = 'ACT_2';
                                            } else {
                                                $is_done['ACT_1'] = $data['activity_type'];
                                                $category = 'ACT_1';
                                            }
                                        }
    
                                        if($data['activity_category'] == 'ACT_2') {
                                            // check if ACT_2 is done
                                            if($data['activity_type'] == 'done') {
                                                $is_done['ACT_2'] = $data['activity_type'];
                                                $category = 'ACT_3';
                                            } else {
                                                $is_done['ACT_2'] = $data['activity_type'];
                                                $category = 'ACT_2';
                                            }
                                        }
    
                                        if($data['activity_category'] == 'ACT_3') {
                                            // check if ACT_3 is done
                                            if($data['activity_type'] == 'done') {
                                                $is_done['ACT_3'] = $data['activity_type'];
                                                $category = 'finished';
                                            } else {
                                                $is_done['ACT_3'] = $data['activity_type'];
                                                $category = 'ACT_3';
                                            }
                                        }
                                    }

                                } else {
                                    $category = 'LOI';
                                }
                                
                                
                                ?>
                                <input type="hidden" name="category" value="<?php echo $category; ?>">

                                <!-- LETTER OF INTENT -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button" data-toggle="collapse" data-target="#letter-of-intent" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($prospecting_letter_of_intent); ?></button>
                                        </p>
                                        <div class="collapse" id="letter-of-intent">

                                            <?php 
                                            $sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE activity_category = 'LOI' AND prospect_id = :id");
                                            $sql->bindParam(":id", $id);
                                            $sql->execute();
                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                            ?>

                                            <div class="card card-body">

                                                <input type="hidden" name="LOI-code" value="LOI<?php echo $id; ?>">
                                                
                                                <div class="row">

                                                    <div class="col-12">
                                                        <h4 class="text-center"><?php echo renderLang($prospecting_letter_of_intent); ?></h4>
                                                    </div>

                                                    <div class="col-lg-3 col-md-4">
                                                        <div class="form-group">
                                                            <label for=""><?php echo renderLang($prospecting_date); ?></label>
                                                            <input type="text" class="form-control date" name="LOI-date" value="<?php echo checkVar($data['activity_date']) ? formatDate($data['activity_date']) : date('Y-m-d'); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-4">
                                                        <div class="form-group">
                                                            <label for=""><?php echo renderLang($lang_status); ?></label>
                                                            <select name="LOI-status" id="" class="form-control">
                                                            <?php echo '<option value="receive">'.renderLang($prospecting_received).'</option>'; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-4">
                                                        <?php $err = isset($_SESSION['sys_prospecting_activity_add_LOI_attachment_err']) ? 1 : 0 ?>
                                                        <div class="form-group">
                                                            <label for="" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($prospecting_attachments); ?></label>
                                                            <input type="file" class="form-control mb-2" name="LOI-attachment">
                                                            <?php 
                                                            echo $err ? '<p class="error-message text-danger mt-2">'.$_SESSION['sys_prospecting_activity_add_LOI_attachment_err'].'</p>' : '';
                                                            unset($_SESSION['sys_prospecting_activity_add_LOI_attachment_err']);
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <?php if(!empty($data['activity_attachment'])){ ?>

                                                    <div class="col-lg-3 col-md-4 text-center">
                                                        <a href="/assets/uploads/activities/<?php echo $data['activity_attachment']; ?>" data-toggle="lightbox">
                                                            <img class="has-bg-img mr-2" src="/assets/uploads/activities/<?php echo $data['activity_attachment']; ?>" style="height: 100px; width: 100px;" class="mr-1"></img>
                                                            <p><?php echo $data['activity_attachment']; ?></p>
                                                        </a>
                                                    </div>

                                                    <?php } ?>

                                                </div>

                                                <div class="card-footer">
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" id="check" class="check-label" <?php echo $data['activity_type'] == 'done' ? 'checked' : '' ?>>
                                                        <label for="check"><?php echo !empty($data['activity_type']) ? ucwords($data['activity_type']) : 'Ongoing'; ?></label>
                                                        <input type="hidden" name="LOI_type" value="<?php echo !empty($data['activity_type']) ? $data['activity_type'] : 'ongoing'; ?>" class="type">
                                                    </div>
                                                </div>
                                            
                                            </div>

                                        </div>
                                    </div>
                                </div>                                

                                <?php if(isset($is_done) && $is_done['LOI'] == 'done') { ?>
                                <!-- FOLLOW UP 1 -->
                                <div class="row d-none">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#activity_1" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($prospecting_activity_1); ?></button>
                                        </p>
                                        <div class="collapse" id="activity_1">

                                            <div class="card card-body">

                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4">
                                                        <?php $err = isset($_SESSION['sys_prospecting_activity_add_ACT_1_attachment_err']) ? 1:0; ?>
                                                        <div class="form-group">
                                                            <label for="" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($prospecting_attachments); ?></label>
                                                            <input type="file" class="form-control mb-2" name="ACT_1-attachment">
                                                            <?php 
                                                            echo $err ? '<p class="error-message text-danger mt-2">'.$_SESSION['sys_prospecting_activity_add_ACT_1_attachment_err'].'</p>' : '';
                                                            unset($_SESSION['sys_prospecting_activity_add_ACT_1_attachment_err']);
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT activity_attachment FROM prospecting_activities WHERE prospect_id = :id AND activity_category = 'ACT_1' AND activity_attachment <> '' ORDER BY id DESC LIMIT 1");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->execute();
                                                    if($sql->rowCount()) {
                                                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    ?>

                                                    <div class="col-lg-3 col-md-4 text-center">
                                                        <a href="/assets/uploads/activities/<?php echo $data['activity_attachment']; ?>" data-toggle="lightbox">
                                                            <img class="has-bg-img mr-2" src="/assets/uploads/activities/<?php echo $data['activity_attachment']; ?>" style="height: 50px; width: 50px;" class="mr-1"></img>
                                                            <p><?php echo $data['activity_attachment']; ?></p>
                                                        </a>
                                                    </div>

                                                    <?php } ?>

                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <th><?php echo renderLang($prospecting_date); ?></th>
                                                            <th><?php echo renderLang($prospecting_action); ?></th>
                                                            <th><?php echo renderLang($prospecting_remarks); ?></th>
                                                        </thead>
                                                        <tbody class="table-data">
                                                        <?php 
                                                            $sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE activity_category = 'ACT_1' AND prospect_id = :id ORDER BY activity_code");
                                                            $sql->bindParam(":id", $id);
                                                            $sql->execute();
                                                            $act_1_type = '';
                                                            $act_1_count = $sql->rowCount();
                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                
                                                                echo '<tr>';

                                                                echo '<td><input type="text" class="form-control date border-0" name="ACT_1-date[]" value="'.formatDate($data['activity_date']).'"></td>';

                                                                echo '<td><textarea name="ACT_1-status[]" rows="2" class="form-control notes border-0">'.$data['activity_status'].'</textarea></td>';

                                                                echo '<td><textarea name="ACT_1-timeline[]" class="form-control notes border-0" rows="2">'.formatDate($data['activity_timeline']).'</textarea></td>';

                                                                echo '</tr>';

                                                                echo '<input type="hidden" name="ACT_1-code[]" value="'.$data['activity_code'].'">';

                                                                $act_1_type = $data['activity_type'];
                                                            }

                                                            if($act_1_count == 0) {

                                                            	echo '<tr>';

                                                                echo '<td><input type="text" class="form-control date border-0" name="ACT_1-date[]" value="'.$data['activity_date'].'"></td>';

                                                                echo '<td><textarea name="ACT_1-status[]" rows="2" class="form-control notes border-0">'.$data['activity_status'].'</textarea></td>';

                                                                echo '<td><textarea name="ACT_1-timeline[]" class="form-control notes border-0" rows="2">'.$data['activity_timeline'].'</textarea></td>';

                                                                echo '</tr>';

                                                                echo '<input type="hidden" name="ACT_1-code[]" value="ACT_1'.$id.'1">';

                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="card-footer">
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" id="act1_check" class="check-label" <?php echo $act_1_type == 'done' ? 'checked' : '' ?>>
                                                        <label for="act1_check"><?php echo !empty($act_1_type) ? ucwords($act_1_type) : 'Ongoing'; ?></label>
                                                        <input type="hidden" name="ACT_1type" value="<?php echo !empty($act_1_type) ? $act_1_type : 'ongoing'; ?>" class="type">
                                                    </div>
                                                </div>
                                                
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php if(isset($is_done) && $is_done['ACT_1'] == 'done' ) { ?>
                                <!-- FOLLOW UP 2 -->
                                <div class="row d-none">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc text-white pms-red" type="button"  data-toggle="collapse" data-target="#activity_2" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($prospecting_activity_2); ?></button>
                                        </p>
                                        <div class="collapse" id="activity_2">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-3 col-md-4">
                                                        <?php $err = isset($_SESSION['sys_prospecting_activity_add_ACT_2_attachment_err']) ? 1:0; ?>
                                                        <div class="form-group">
                                                            <label for="" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($prospecting_attachments); ?></label>
                                                            <input type="file" class="form-control mb-2" name="ACT_2-attachment">
                                                            <?php 
                                                            echo $err ? '<p class="error-message text-danger mt-2">'.$_SESSION['sys_prospecting_activity_add_ACT_2_attachment_err'].'</p>' : '';
                                                            unset($_SESSION['sys_prospecting_activity_add_ACT_2_attachment_err']);
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT activity_attachment FROM prospecting_activities WHERE prospect_id = :id AND activity_category = 'ACT_2' AND activity_attachment <> '' ORDER BY id DESC LIMIT 1");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->execute();
                                                    if($sql->rowCount()) {
                                                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    ?>

                                                    <div class="col-lg-3 col-md-4 text-center">
                                                        <a href="/assets/uploads/activities/<?php echo $data['activity_attachment']; ?>" data-toggle="lightbox">
                                                            <img class="has-bg-img mr-2" src="/assets/uploads/activities/<?php echo $data['activity_attachment']; ?>" style="height: 50px; width: 50px;" class="mr-1"></img>
                                                            <p><?php echo $data['activity_attachment']; ?></p>
                                                        </a>
                                                    </div>

                                                    <?php } ?>

                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <th><?php echo renderLang($prospecting_date); ?></th>
                                                            <th><?php echo renderLang($prospecting_status); ?></th>
                                                            <th><?php echo renderLang($prospecting_timeline); ?></th>
                                                        </thead>
                                                        <tbody class="table-data">
                                                        <?php 
                                                            $sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE activity_category = 'ACT_2' AND prospect_id = :id ORDER BY activity_code");
                                                            $sql->bindParam(":id", $id);
                                                            $sql->execute();
                                                            $act_2_type = '';
                                                            $act_2_count = $sql->rowCount() ? $sql->rowCount() : 0;
                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                
                                                                echo '<tr>';

                                                                echo '<td><input type="text" class="form-control date border-0" name="ACT_2-date[]" value="'.formatDate($data['activity_date']).'"></td>';

                                                                echo '<td><textarea name="ACT_2-status[]" rows="2" class="form-control notes border-0">'.$data['activity_status'].'</textarea></td>';

                                                                echo '<td><textarea name="ACT_2-timeline[]" class="form-control notes border-0" rows="2">'.formatDate($data['activity_timeline']).'</textarea></td>';

                                                                echo '</tr>';

                                                                echo '<input type="hidden" name="ACT_2-code[]" value="'.$data['activity_code'].'">';

                                                                $act_2_type = $data['activity_type'];
                                                            }

                                                            if($act_2_count == 0) {

                                                            	echo '<tr>';

                                                                echo '<td><input type="text" class="form-control date border-0" name="ACT_2-date[]" value="'.$data['activity_date'].'"></td>';

                                                                echo '<td><textarea name="ACT_2-status[]" rows="2" class="form-control notes border-0">'.$data['activity_status'].'</textarea></td>';

                                                                echo '<td><textarea name="ACT_2-timeline[]" class="form-control notes border-0" rows="2">'.$data['activity_timeline'].'</textarea></td>';

                                                                echo '</tr>';

                                                                echo '<input type="hidden" name="ACT_2-code[]" value="ACT_2'.$id.'1">';

                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="card-footer">
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" id="act2_check" class="check-label" <?php echo $act_2_type == 'done' ? 'checked' : '' ?>>
                                                        <label for="act2_check"><?php echo !empty($act_2_type) ? ucwords($act_2_type) : 'Ongoing'; ?></label>
                                                        <input type="hidden" name="ACT_2type" value="<?php echo !empty($act_2_type) ? $act_2_type : 'ongoing'; ?>" class="type">
                                                    </div>
                                                </div>
                                            
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php if(isset($is_done) && $is_done['ACT_2'] == 'done') { ?>
                                <!-- FOLLOW UP 3 -->
                                <div class="row d-none">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#activity_3" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($prospecting_activity_3); ?></button>
                                        </p>
                                        <div class="collapse" id="activity_3">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-3 col-md-4">
                                                        <?php $err = isset($_SESSION['sys_prospecting_activity_add_ACT_3_attachment_err']) ? 1:0; ?>
                                                        <div class="form-group">
                                                            <label for="" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($prospecting_attachments); ?></label>
                                                            <input type="file" class="form-control mb-2" name="ACT_3-attachment">
                                                            <?php 
                                                            echo $err ? '<p class="error-message text-danger mt-2">'.$_SESSION['sys_prospecting_activity_add_ACT_3_attachment_err'].'</p>' : '';
                                                            unset($_SESSION['sys_prospecting_activity_add_ACT_3_attachment_err']);
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT activity_attachment FROM prospecting_activities WHERE prospect_id = :id AND activity_category = 'ACT_3' AND activity_attachment <> '' ORDER BY id DESC LIMIT 1");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->execute();
                                                    if($sql->rowCount()) {
                                                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    ?>

                                                    <div class="col-lg-3 col-md-4 text-center">
                                                        <a href="/assets/uploads/activities/<?php echo $data['activity_attachment']; ?>" data-toggle="lightbox">
                                                            <img class="has-bg-img mr-2" src="/assets/uploads/activities/<?php echo $data['activity_attachment']; ?>" style="height: 50px; width: 50px;" class="mr-1"></img>
                                                            <p><?php echo $data['activity_attachment']; ?></p>
                                                        </a>
                                                    </div>

                                                    <?php } ?>

                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <th><?php echo renderLang($prospecting_date); ?></th>
                                                            <th><?php echo renderLang($prospecting_status); ?></th>
                                                            <th><?php echo renderLang($prospecting_timeline); ?></th>
                                                        </thead>
                                                        <tbody class="table-data">
                                                        <?php 
                                                            $sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE activity_category = 'ACT_3' AND prospect_id = :id ORDER BY activity_code");
                                                            $sql->bindParam(":id", $id);
                                                            $sql->execute();
                                                            $act_3_type = '';
                                                            $act_3_count = $sql->rowCount() ? $sql->rowCount() : 0;
                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                
                                                                echo '<tr>';

                                                                echo '<td><input type="text" class="form-control date border-0" name="ACT_3-date[]" value="'.formatDate($data['activity_date']).'"></td>';

                                                                echo '<td><textarea name="ACT_3-status[]" rows="2" class="form-control notes border-0">'.$data['activity_status'].'</textarea></td>';

                                                                echo '<td><textarea name="ACT_3-timeline[]" class="form-control notes border-0" rows="2">'.formatDate($data['activity_timeline']).'</textarea></td>';

                                                                echo '</tr>';

                                                                echo '<input type="hidden" name="ACT_3-code[]" value="'.$data['activity_code'].'">';

                                                                $act_3_type = $data['activity_type'];
                                                            }

                                                            if($act_3_count == 0) {

                                                            	echo '<tr>';

                                                                echo '<td><input type="text" class="form-control date border-0" name="ACT_3-date[]" value="'.$data['activity_date'].'"></td>';

                                                                echo '<td><textarea name="ACT_3-status[]" rows="2" class="form-control notes border-0">'.$data['activity_status'].'</textarea></td>';

                                                                echo '<td><textarea name="ACT_3-timeline[]" class="form-control notes border-0" rows="2">'.$data['activity_timeline'].'</textarea></td>';

                                                                echo '</tr>';

                                                                echo '<input type="hidden" name="ACT_3-code[]" value="ACT_3'.$id.'1">';

                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="card-footer">
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" id="act3_check" class="check-label" <?php echo $act_3_type == 'done' ? 'checked' : '' ?>>
                                                        <label for="act3_check"><?php echo !empty($act_3_type) ? ucwords($act_3_type) : 'Ongoing'; ?></label>
                                                        <input type="hidden" name="ACT_3type" value="<?php echo !empty($act_3_type) ? $act_3_type : 'ongoing'; ?>" class="type">
                                                    </div>
                                                </div>
                                            
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <!-- ACTIVITIES -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#activity" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($prospecting_activities); ?></button>
                                        </p>
                                        <div class="collapse" id="activity">

                                            <div class="card card-body">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <th><?php echo renderLang($prospecting_date); ?></th>
                                                            <th><?php echo renderLang($prospecting_action_plan); ?></th>
                                                            <th><?php echo renderLang($prospecting_timeline); ?></th>
                                                            <th><?php echo renderLang($prospecting_attachments); ?></th>
                                                        </thead>
                                                        <tbody class="table-data">
                                                        <?php 
                                                            $sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE activity_category = 'ACT' AND prospect_id = :id ORDER BY activity_date DESC");
                                                            $sql->bindParam(":id", $id);
                                                            $sql->execute();
                                                            $act_type = '';
                                                            $act_num = 0;
                                                            $act_count = $sql->rowCount() ? $sql->rowCount() : 0;
                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

																$if_curr_date = 0;//$current_date == formatDate($data['activity_date']) ? 0 : 1;
                                                                
                                                                echo '<tr>';

                                                                echo '<input type="hidden" name="ACT_id[]" value="'.$data['id'].'">';

                                                                echo '<td><input type="text" class="form-control border-0 input-readonly" name="ACT-date[]" value="'.formatDate($data['activity_date']).'" readonly></td>';

                                                                echo '<td><textarea name="ACT-status[]" rows="2" class="form-control notes border-0" '.($if_curr_date ? 'readonly' : '').'>'.$data['activity_status'].'</textarea></td>';

                                                                echo '<td><input type="text" class="form-control '.($if_curr_date ? 'input-readonly' : 'date').' border-0" name="ACT-timeline[]" value="'.formatDate($data['activity_timeline']).'" '.($if_curr_date ? 'readonly' : '').'></td>';

                                                                echo '<td>';
                                                                if(!empty($data['activity_attachment'])) {

                                                                    $img_ext = array('jpg', 'jpeg', 'png');
                                                                    if(strpos($data['activity_attachment'], ',')) {
                                    
                                                                        $attachments = explode(',', $data['activity_attachment']);
                                                                        foreach($attachments as $attachment) {
                                    
                                                                            $attachment_part = explode('.', $attachment);
                                                                            
                                                                            if(in_array(strtolower($attachment_part[1]), $img_ext)) {
                                    
                                                                                
                                                                                    echo '<a href="/assets/uploads/activities/'.$attachment.'" data-toggle="lightbox">'; 
                                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/activities/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                                        echo $attachment;
                                                                                    echo '<button class="btn btn-sm btn-danger float-right"><i class="fa fa-times"></i></button></a><br>';
                                    
                                                                            } else {
                                    
                                                                                echo '<a href="/assets/uploads/activities/'.$attachment.'" target="_blank">'.$attachment.'<button class="btn btn-sm btn-danger float-right"><i class="fa fa-times"></i></button></a><br>';
                                    
                                                                            }
                                    
                                                                        }
                                    
                                                                    } else {
                                    
                                                                        $attachment_part = explode('.', $data['activity_attachment']);
                                                                        if(in_array(strtolower($attachment_part[1]), $img_ext)) {
                                    
                                                                                
                                                                            echo '<a href="/assets/uploads/activities/'.$data['activity_attachment'].'" data-toggle="lightbox">'; 
                                                                                echo '<img class="has-bg-img mr-2" src="/assets/uploads/activities/'.$data['activity_attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                                echo $data['activity_attachment'];
                                                                            echo '<button class="btn btn-sm btn-danger float-right btn-delete"><i class="fa fa-times"></i></button></a><br>';
                                    
                                                                        } else {
                                    
                                                                            echo '<a href="/assets/uploads/activities/'.$data['activity_attachment'].'" target="_blank">'.$data['activity_attachment'].'<button class="btn btn-sm btn-danger float-right btn-delete mb-1"><i class="fa fa-times"></i></button></a><br>';
                                    
                                                                        }
                                                                    
                                                                    }
                                    
                                                                }
                                                                echo '<input type="file" name="ACT-attachment'.$act_num.'" class="form-control mt-1">';
                                                                echo '</td>';

                                                                echo '</tr>';

                                                                echo '<input type="hidden" name="ACT-code[]" value="'.$data['activity_code'].'">';

                                                                $act_type = $data['activity_type'];
                                                                $act_num++;
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-right">
                                                        <button data-code="ACT" class="btn btn-info add-row" type="button"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                    </div>
                                                </div>
                                            
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo renderLang($prospecting_remarks); ?></th>
                                                        <th><?php echo renderLang($lang_date); ?></th>
                                                        <th><?php echo renderLang($prospecting_remarks_by); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="remarks-table-data">
                                                    <?php 

                                                    // 
                                                    if(checkVar($_data['other_remarks'])) {
                                                        echo '<tr>';
                                                            echo '<td><p>'.$_data['other_remarks'].'</p></td>';
                                                            echo '<td></td>';
                                                            echo '<td></td>';
                                                        echo '</tr>';
                                                    }

                                                    $sql = $pdo->prepare("SELECT * FROM prospecting_activity_remarks WHERE prospect_id = :id");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->execute();
                                                    if($sql->rowCount()) {
                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                            echo '<tr>';
                                                                echo '<td><p>'.$data['remarks'].'</p></td>';
                                                                echo '<td>'.formatDate($data['created_date']).'</td>';
                                                                // remarks by
                                                                echo '<td>';
                                                                    if($data['account_mode'] == 'employee') {
                                                                        echo getField("code_name", "employees", "id = ".$data['created_by']);
                                                                    } else {
                                                                        echo getFullName($data['created_by'], 'user');
                                                                    }
                                                                echo '</td>';
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        if(!checkVar($_data['other_remarks'])) {
                                                            echo '<tr>';
                                                                echo '<td colspan="3" class="text-center">'.renderLang($lang_no_data).'</td>';
                                                            echo '</tr>';
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="remarks"><?php echo renderLang($prospecting_remarks); ?></label>
                                            <textarea name="ACT-remarks" id="remarks" rows="3" class="form-control notes"></textarea>
                                        </div>
                                        <div class="text-right mt-2">
                                            <button class="btn btn-primary" id="add-remarks"><i class="fa fa-plus mr-1"></i><?php echo renderLang($prospect_add_remarks); ?></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/prospecting-list/<?php echo $_data['prospecting_category']; ?>" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-success"><i class="fa fa-save mr-1"></i><?php echo renderlang($lang_save); ?></button>
                            </div>
                        </div>

                    </form>

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
		$(function(){

            // add remarks function
            $('#add-remarks').on('click', function(e){
                e.preventDefault();

                var remarks = $('#remarks').val();
                var prospect_id = <?php echo $id; ?>;

                $.post('/add-prospect-activity-remarks', {
                    remarks:remarks, prospect_id:prospect_id
                }, function(data){
                    $('#remarks').val('');
                    $('.remarks-table-data').html(data);
                });

            });

            // pictures
            $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format : 'YYYY-MM-DD'
                    }
                });
            });

            var num = [];
            num['ACT'] = <?php echo $act_count; ?>;
            $('.add-row').on('click', function(e){
                e.preventDefault();

                var code = $(this).data('code');

                var row_fields = '<td><input type="text" class="form-control border-0 input-readonly" name="'+code+'-date[]" value="<?php echo formatDate(date('Y-m-d')); ?>" readonly></td><td><textarea name="'+code+'-status[]" rows="2" class="form-control notes border-0"></textarea></td><td><input type="text" class="form-control date border-0" name="'+code+'-timeline[]"></td><td><input type="file" name="'+code+'-attachment'+num[code]+'" class="form-control"></td>';

                $(this).closest('.table-responsive').find('.table-data').append('<tr><input type="hidden" name="ACT_id[]" value="0">'+row_fields+'</tr><input type="hidden" name="'+code+'-code[]" value="'+code+'<?php echo $id; ?>'+num[code]+'">');

                num[code]++;

                $('.date').each(function(){
                    $(this).daterangepicker({
                        singleDatePicker: true,
                        locale: {
                            format : 'YYYY-MM-DD'
                        }
                    });
                });

            });

            $('.check-label').on('change', function(e){

                if($(this).is(':checked')) {
                    $(this).closest('div').find('.type').val('done');
                    $(this).closest('div').find('label').html('Done');
                } else {
                    $(this).closest('div').find('.type').val('ongoing');
                    $(this).closest('div').find('label').html('Ongoing');
                }

            });

            // delete attachment
            $('body').on('click', '.btn-delete', function(e){
                e.preventDefault();
                // prevent parent trigger
                e.stopPropagation();
                var id = $(this).closest('tr').find('input[name="ACT_id[]"]').val();
                var $this = $(this);
                if(confirm("Are you sure to permanently delete this attachment?")) {
                    $.post('/delete-prospecting-activity-attachment', {
                        id:id
                    }, function(data){
                        if(data == "invalid-session") {
                            window.location.href = "/dashboard";
                        }
                        if(data == "no-session") {
                            window.location.href = "/";
                        }
                        $this.closest('a').remove();
                    });
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