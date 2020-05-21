<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-esd-edit')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'proposal';
        
        $prospect_id = $_GET['id'];

        $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $prospect_id);
        $sql->execute();
        $_data = array();
        if($sql->rowCount()) {
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
        }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($proposals_edit); ?> &middot; <?php echo $sitename; ?></title>
	
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
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
							<h1>
                                <i class="fas fa-handshake mr-3"></i><?php echo renderLang($proposals_edit); ?>
                                <span class="fa fa-chevron-right mr-2 ml-2"></span>
                                <?php echo isset($_data) ? $_data['project_name'] : ''; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_proposal_edit_suc');
                    renderError('sys_proposal_edit_err');
                    ?>

                    <form action="/save-esd-proposal-letter" method="post" enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($proposals_edit); ?></h3>
                            </div>
                            <div class="card-body">

                                <!-- attachment -->
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        <label for=""><?php echo renderLang($proposals_attachment); ?></label>
                                        <input type="file" class="form-control" name="attachment[]" multiple>
                                    </div>
                                    <div class="col-lg-9 colmd-8">
                                    <?php 
                                    $proposal_id = 0;
                                    if(isset($_data)) {
                                        $sql = $pdo->prepare("SELECT * FROM proposals WHERE prospect_id = :prospect_id LIMIT 1");
                                        $sql->bindParam(":prospect_id", $_data['id']);
                                        $sql->execute();
                                        if($sql->rowCount()) {

                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                            $proposal_id = $data['id'];

                                            if(!empty($data['attachment'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($data['attachment'], ',')) {

                                                    $attachments = explode(',', $data['attachment']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/proposals/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/proposals/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/proposals/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/proposals/'.$data['attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/proposals/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $data['attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/proposals/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }

                                        }

                                    }
                                    ?>
                                    </div>
                                </div>
                                <hr>
                                <p class="text-danger"><?php echo renderLang($proposals_please_refer); ?> *</p>

                                <div class="row">
                                    <div class="col-12">
                                    
                                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true"><?php echo renderLang($proposals_letter); ?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#second-tab" role="tab" aria-controls="custom-content-below-profile" aria-selected="false"><?php echo renderLang($proposals_services); ?></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="custom-content-below-tabContent">
                                            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">

                                                <div class="card card-body">

                                                    <div class="row">

                                                        <div class="col-lg-2">
                                                            <input type="hidden" name="prospect_id" value="<?php echo $prospect_id; ?>">
                                                        </div>

                                                            <div class="col-lg-8">       

                                                                <!-- address -->
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <p><?php echo isset($_data) ? $_data['location'] : '' ; ?></p>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                                $letter_data = array();
                                                                $sql = $pdo->prepare("SELECT * FROM proposal_letter WHERE proposal_id = :proposal_id LIMIT 1");
                                                                $sql->bindParam(":proposal_id", $proposal_id);
                                                                $sql->execute();
                                                                if($sql->rowCount()) {
                                                                    $letter_data = $sql->fetch(PDO::FETCH_ASSOC);
                                                                }
                                                                ?>

                                                                <!-- Honorifics -->
                                                                <div class="row">
                                                                    <div class="col-3">
                                                                        <input type="text" class="form-control certify-border border-bottom" name="honorific" placeholder="<?php echo renderLang($proposals_dear); ?>" value="<?php echo !empty($letter_data) ? $letter_data['honorifics'] : ''; ?>">
                                                                    </div>
                                                                </div>

                                                                <!-- paragrapgh 1 -->
                                                                <div class="row mt-3">
                                                                    <div class="col-12">
                                                                        <p class="text-justify">
                                                                            <?php echo renderLang($proposals_paragraph1_text_1); ?>
                                                                            <input type="text" name="service" class="w300 ml-1 mr-1 certify-border border-bottom text-center" value="<?php echo !empty($letter_data) ? $letter_data['services'] : ''; ?>">
                                                                            <?php echo renderLang($proposals_paragraph1_text_2); ?>
                                                                            <input type="text" name="location" class="w300 ml-1 mr-1 certify-border border-bottom text-center" value="<?php echo !empty($letter_data) ? $letter_data['location'] : ''; ?>">
                                                                            <?php echo renderLang($proposals_paragraph1_text_3); ?>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <!-- paragraph 2 -->
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p class="text-justify">
                                                                            <?php echo renderLang($proposals_pragraph2_text_1); ?>
                                                                            <input type="text" name="days" class="w100 ml-1 mr-1 certify-border border-bottom text-center" value="<?php echo !empty($letter_data) ? $letter_data['days'] : ''; ?>">
                                                                            <?php echo renderLang($proposals_pragraph2_text_2); ?>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <!-- paragraph 3 -->
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p class="text-justify">
                                                                            <?php echo renderLang($proposals_paragraph3_text_1); ?>
                                                                            <input type="text" name="service_fee" class="w300 ml-1 mr-1 certify-border border-bottom text-center" value="<?php echo !empty($letter_data) ? $letter_data['service_fee'] : ''; ?>">
                                                                            <?php echo renderLang($proposals_paragraph3_text_2); ?>
                                                                            <input type="text" name="term_of_payment" class="w300 ml-1 mr-1 certify-border border-bottom text-center" value="<?php echo !empty($letter_data) ? $letter_data['term_of_payment'] : ''; ?>">
                                                                            <?php echo renderLang($proposals_paragraph3_text_3); ?>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <!-- paragraph 4 -->
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p class="text-justify">
                                                                            <?php echo renderLang($proposals_paragraph4_text_1); ?>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <!-- paragraph 5 -->
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p class="text-justify">
                                                                            <?php echo renderLang($proposals_paragraph5_text_1); ?>
                                                                            <input type="text" name="fax_number" class="w200 ml-1 mr-1 certify-border border-bottom text-center" value="<?php echo !empty($letter_data) ? $letter_data['fax_number'] : '815 2915'; ?>">
                                                                            <?php echo renderLang($proposals_paragraph5_text_2); ?>
                                                                            <input type="text" name="email" class="w200 ml-1 mr-1 certify-border border-bottom text-center" value="<?php echo !empty($letter_data) ? $letter_data['email'] : 'esdteam@fpdasia.net'; ?>">
                                                                            <?php echo renderLang($proposals_paragraph5_text_3); ?>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <!-- paragraph 6 -->
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p class="text-justify">
                                                                            <?php echo renderLang($proposals_paragraph6_text_1); ?>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <!-- author -->
                                                                    <div class="col-6">
                                                                        <p class="text-justify">
                                                                            <?php echo renderLang($proposals_very_truly_yours); ?>
                                                                        </p>
                                                                        <div class="form-group col-lg-10 mt-5">
                                                                            <input type="text" name="author" class="form-control certify-border border-bottom"  value="<?php echo !empty($letter_data) ? $letter_data['author'] : ''; ?>">
                                                                            <p class="text-justify">Sr. Account Engineer</p>
                                                                            <p>Engineering Services Division</p>
                                                                        </div>
                                                                    </div>

                                                                    <!-- free form -->
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <input type="text" name="notes" class="form-control" value="<?php echo !empty($letter_data) ? $letter_data['notes'] : ''; ?>">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row mt-3">

                                                                    <div class="col-6">
                                                                        <p><?php echo renderLang($proposals_noted_by); ?>:</p>
                                                                        <div class="form-group col-lg-10 mt-5">
                                                                            <input type="text" name="noted_by" class="form-control certify-border border-bottom" value="<?php echo !empty($letter_data) ? $letter_data['noted_by'] : ''; ?>">
                                                                            <p class="text-justify">Director</p>
                                                                            <p>Engineering Services Division</p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6">
                                                                        <p><?php echo renderLang($proposals_conforme); ?>:</p>
                                                                        <div class="form-group col-lg-10 mt-5">
                                                                            <input type="text" name="conforme" class="form-control certify-border border-bottom" value="<?php echo !empty($letter_data) ? $letter_data['conforme'] : ''; ?>">
                                                                            <p class="text-justify"><?php echo renderLang($proposals_printed_name_and_signature); ?></p>
                                                                            <p>
                                                                                <?php echo renderLang($proposals_contact_no); ?>
                                                                                <input type="text" name="contact_number" class="ml-2 w200 certify-border border-bottom" value="<?php echo !empty($letter_data) ? $letter_data['contact_no'] : ''; ?>">
                                                                            </p>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div> 

                                                        <div class="col-lg-2"></div>

                                                    </div>

                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="second-tab" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">

                                                <div class="card card-body">

                                                    <?php
                                                    $service_id = 0; 
                                                    $date = '';
                                                    $subject = '';
                                                    $service_honorifics = '';
                                                    $prepared_by = '';
                                                    $checked_by = '';
                                                    if(!empty($proposal_id)) {

                                                        $sql = $pdo->prepare("SELECT * FROM proposal_services WHERE proposal_id = :proposal_id");
                                                        $sql->bindParam(":proposal_id", $proposal_id);
                                                        $sql->execute();
                                                        if($sql->rowCount()) {
                                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                            $service_id = $data['id'];
                                                            $date = $data['date'];
                                                            $subject = $data['subject'];
                                                            $service_honorifics = $data['honorifics'];
                                                            $prepared_by = $data['prepared_by'];
                                                            $checked_by = $data['checked_by'];
                                                        }
                                                    }
                                                    ?>

                                                    <div class="row">
                                                        
                                                        <!-- Date -->
                                                        <div class="col-lg-3 col-md-4 col-sm-4">
                                                            <label for="date"><?php echo renderLang($lang_date); ?></label>
                                                            <input type="text" id="date" name="date" class="form-control date" value="<?php echo isset($date) ? formatDate($date) : date('y-m-d'); ?>">
                                                        </div>

                                                        <!-- Subject -->
                                                        <div class="col-lg-5 col-md-8 col-sm-8">
                                                            <label for="subject"><?php echo renderLang($proposals_subject); ?></label>
                                                            <input type="text" class="form-control" name="subject" id="subject" value="<?php echo $subject; ?>">
                                                        </div>

                                                    </div>

                                                    <!-- honorifics -->
                                                    <div class="row mt-4">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <input type="text" name="service_honorifics" class="form-control input-readonly" placeholder="<?php echo renderLang($proposals_dear); ?>" value="<?php echo renderLang($proposals_dear); ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- find herewith -->
                                                    <div class="row mt-2">
                                                        <div class="col-12">
                                                            <p>
                                                                <?php echo renderLang($proposals_find_here_with); ?>:
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <!-- Scope of Services -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <b>
                                                                1. <?php echo renderLang($proposal_scope_of_service_arr['title']); ?>
                                                            </b>
                                                        </div>
                                                        <div class="col-12">
                                                            <ul>
                                                                <?php 
                                                                foreach($proposal_scope_of_service_arr['list'] as $key => $value) {
                                                                    echo '<li>'.renderLang($value).'</li>';
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <!-- Service Area -->
                                                    <div class="row">

                                                        <!-- title -->
                                                        <div class="col-12">
                                                            <b>
                                                                2. <?php echo renderLang($proposals_service_area); ?>
                                                            </b>
                                                        </div>

                                                        <!-- note -->
                                                        <div class="col-12">
                                                            <p class="pl-3 ml-2">
                                                                <?php echo renderLang($proposals_provice_a_service); ?>
                                                            </p>
                                                        </div>

                                                        <!-- table -->
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><?php echo renderLang($proposals_quantity); ?></th>
                                                                            <th><?php echo renderLang($proposals_description); ?></th>
                                                                            <th><?php echo renderLang($proposals_location); ?></th>
                                                                            <th><?php echo renderLang($proposals_unit_price); ?></th>
                                                                            <th><?php echo renderLang($proposals_total_price); ?></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        if(!empty($service_id)) {
                                                                            $sql = $pdo->prepare("SELECT * FROM proposal_service_area WHERE service_id = :service_id");
                                                                            $sql->bindParam(":service_id", $service_id);
                                                                            $sql->execute();
                                                                            if($sql->rowCount()) {
                                                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                                    echo '<tr>';
                                                                                        echo '<input type="hidden" name="service_area_id[]" value="'.$data['id'].'">';
                                                                                        echo '<td><input type="number" class="form-control border-0 qty" name="quantity[]" min="1" value="'.$data['quantity'].'"></td>';
                                                                                        echo '<td><input type="text" class="form-control border-0" name="description[]" value="'.$data['description'].'"></td>';
                                                                                        echo '<td><input type="text" class="form-control border-0" name="service_location[]" value="'.$data['location'].'"></td>';
                                                                                        echo '<td><input type="text" class="form-control border-0 amount" name="unit_price[]" data-type="currency" value="'.$data['unit_price'].'"></td>';
                                                                                        echo '<td><input type="text" class="form-control border-0 input-readonly total" name="total_price[]" readonly value="'.$data['total_price'].'"></td>';
                                                                                    echo '</tr>';
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <tr class="default-row">
                                                                            <input type="hidden" name="service_area_id[]" value="0">
                                                                            <td><input type="number" class="form-control border-0 qty" name="quantity[]" min="1"></td>
                                                                            <td><input type="text" class="form-control border-0" name="description[]"></td>
                                                                            <td><input type="text" class="form-control border-0" name="service_location[]"></td>
                                                                            <td><input type="text" class="form-control border-0 amount" name="unit_price[]" data-type="currency"></td>
                                                                            <td><input type="text" class="form-control border-0 input-readonly total" name="total_price[]" readonly></td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="4"></td>
                                                                            <td><input type="text" class="form-control input-readonly border-0" readonly id="grand-total"></td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="text-right">
                                                                    <a href="" class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>

                                                    <div class="row">
                                                        <!-- Prepared by -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($proposals_prepared_by); ?></label>
                                                                <input type="text" class="form-control w300" value="<?php echo isset($prepared_by) ? $prepared_by : getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']); ?>" name="prepared_by">
                                                            </div>
                                                        </div>
                                                        <!-- Checked and Noted by -->
                                                        <div class="col-md-6">
                                                            <label for=""><?php echo renderLang($proposals_checked_and_noted_by); ?></label>
                                                            <input type="text" class="form-control w300" name="service_noted_by" value="<?php echo $checked_by; ?>">
                                                        </div>
                                                    </div>
                                                        
                                                </div>

                                            </div>
                                        
                                        </div>
                                        
                                    </div>

                                </div>

                                                

                            </div>
                            <div class="card-footer text-right">
                                <a href="/esd-proposals" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($proposals_update_proposal); ?></button>
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
	<script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
    $(function(){
        
        // data table
            $('#table-data').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        // 
        
        // lightbox
            $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
        // 

        // format date
            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format : 'YYYY-MM-DD'
                    }
                });
            });
        // 

        // auto compute total
            // count grand total
            var grand_total = 0;
            $('.total').each(function(){
                var val = $(this).val();
                val = val.replace(/,/g, "").replace(/₱/g, "");
                grand_total += val * 1;
            });

            $('#grand-total').val(grand_total);
            formatCurrency($('#grand-total'), "blur");

            $('body').on('change, keyup', '.amount', function(){

                grand_total = 0;

                var price = $(this).val();
                price = price.replace(/,/g, '').replace('₱', '');
                var qty = $(this).closest('tr').find('.qty').val();

                if(qty == '' || qty == null) {
                    qty = 1;
                }

                var total = qty * price;
                
                $(this).closest('tr').find('.total').val(total);
                var $total = $(this).closest('tr').find('.total');
                formatCurrency($total, "blur");

                $('.total').each(function(){
                    var val = $(this).val();
                    val = val.replace(/,/g, "").replace(/₱/g, "");
                    grand_total += val * 1;
                });

                $('#grand-total').val(grand_total);
                formatCurrency($('#grand-total'), "blur");

            });
            $('body').on('change', '.qty', function(){
                
                grand_total = 0;

                var qty = $(this).val();
                var amount = $(this).closest('tr').find('.amount').val();
                var price = amount.replace(/,/g, '').replace('₱', '');

                if(qty == '' || qty == null) {
                    qty = 1;
                }

                var total = qty * price;

                $(this).closest('tr').find('.total').val(total);
                var $total = $(this).closest('tr').find('.total');
                formatCurrency($total, "blur");

                $('.total').each(function(){
                    var val = $(this).val();
                    val = val.replace(/,/g, "").replace(/₱/g, "");
                    grand_total += val * 1;
                });

                $('#grand-total').val(grand_total);
                formatCurrency($('#grand-total'), "blur");

            });
        // 

        // add row
            $('.add-row').on('click', function(e){
                e.preventDefault();

                var row = $(this).closest('.table-responsive').find('.default-row').html();
                $(this).closest('.table-responsive').find('tbody').append('<tr>'+row+'</tr>');

            });
        // 

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