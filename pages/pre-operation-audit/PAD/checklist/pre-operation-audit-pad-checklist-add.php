<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
    
    // check permission to access this page or function
    if(checkPermission('pre-operation-audit-PAD-add')) {

    $page = 'pre-operation-audit';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo renderLang($pre_operation_audit_pad_checklist_page); ?> &middot; <?php echo $sitename; ?></title>

    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
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
                            <h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_pad_checklist_page); ?></h1>
                        </div>
                    </div>
                    
                </div><!-- container-fluid -->
            </section><!-- content-header -->

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">

                    <form action="/submit-add-pad-checklist-pre-operation-audit" method="post"  enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_pad_checklist_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <!-- prospect -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="prospect_id"><?php echo renderLang($pre_operation_audit_project); ?></label>
                                            <select name="prospect_id" id="prospect_id" class="form-control select2">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT reference_number, project_name, id FROM prospecting WHERE status = 3 AND prospecting_category = 0 AND temp_del = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- date -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date"><?php echo renderLang($pre_operation_audit_pcc_date); ?></label>
                                            <input type="text" class="form-control date" name="date" id="date">
                                        </div>
                                    </div>

                                </div>

                                <!-- A. REGISTRATION PERMIT & LICENCES -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-A" aria-expanded="false" aria-controls="collapseExample">A. <?php echo renderLang($pad_turnover_audit_checklist_arr['A']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-A">

                                            <div class="card card-body">

                                                <?php 
                                                $num = 0;
                                                foreach($pad_turnover_audit_checklist_A_arr as $key => $value) { 

                                                    if ($key == '4' || $key == '5' || $key == '6' ) {

                                                        echo '<div class=" show456">';
                                                    }

                                                ?>
                                                <div class="row">
                                                    
                                                    <div class="<?php echo $key < 4 ? 'border-right col-lg-8 ' : 'col-12 ' ?>row">
                                                        <div class='col-12'>
                                                            <h4 ><?php echo $key.'. '.renderLang($value['title']); ?></h4>
                                                        </div>

                                                        <?php 
                                                        if($key == '1') {

                                                            foreach($value['fields'] as $field_key => $field) {

                                                                switch($field_key) {
                                                                    case 'A':

                                                                        // BIR CERTIFICATE OF REGISTRATION
                                                                        echo '<div class="col-md-4">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.$key.$field_key.'. '.renderLang($field[0]).'</label>';
                                                                                echo '<input type="text" class="form-control" name="bir_cor_number">';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        // BIR DATE
                                                                        echo '<div class="col-md-4">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.renderLang($pre_operation_audit_pcc_date).'</label>';
                                                                                echo '<input type="text" class="form-control date" name="bir_date">';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        // RDO No.
                                                                        echo '<div class="col-md-4">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.renderLang($pre_operation_audit_pad_rdo_no).'</label>';
                                                                                echo '<input type="text" class="form-control" name="rdo_number">';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        // BIR ATTACHMENT
                                                                        echo '<div class="col-md-4 row">';
                                                                            echo '<div class="col-12">';
                                                                                echo '<div class="form-group">';
                                                                                    echo '<label for="">('.renderLang($pre_operation_audit_pad_pls_attach_copy).')</label>';
                                                                                    echo '<input type="file" class="form-control" name="attachments0[]" multiple>';
                                                                                    echo '<input type="hidden" name="attachment_category[]" value="A1">';
                                                                                    echo '<input type="hidden" name="accounting_remarks[]">';
                                                                                echo '</div>';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        foreach($field[1] as $check_key => $check) {

                                                                            if($check_key == 1) {

                                                                                // BIR DISPLAY NO
                                                                                echo '<div class="col-lg-6">';
                                                                                    echo '<div class="form-group clearfix">';
                                                                                        echo '<div class="icheck-danger d-inline">';
                                                                                            echo '<input type="radio" id="bir_display_no" name="bir_display" value="0" checked>';
                                                                                            echo '<label for="bir_display_no">'.renderLang($check).'</label>';
                                                                                        echo '</div>';
                                                                                    echo '</div>';
                                                                                echo '</div>';

                                                                                // BIR DISPLAY SPECIFY
                                                                                echo '<div class="col-lg-6">';
                                                                                    echo '<div class="form-group">';
                                                                                        echo '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                                                                        echo '<input type="text" class="form-control" name="bir_display_specify">';
                                                                                    echo '</div>';
                                                                                echo '</div>';

                                                                            } else {

                                                                                // BIR DISPLAY yes
                                                                                echo '<div class="col-12">';
                                                                                    echo '<div class="form-group clearfix">';
                                                                                        echo '<div class="icheck-success d-inline">';
                                                                                            echo '<input type="radio" id="bir_display_yes" name="bir_display" value="1">';
                                                                                            echo '<label for="bir_display_yes">'.renderLang($check).'</label>';
                                                                                        echo '</div>';
                                                                                    echo '</div>';
                                                                                echo '</div>';
                                                                            }

                                                                        }

                                                                    break;

                                                                    case 'B':

                                                                        echo '<div class="col-12">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.$key.$field_key.'. '.renderLang($field[0]).'</label>';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        echo '<div class="col-12 ml-2">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.renderLang($pre_operation_audit_pad_industry).'</label>';
                                                                                echo '<input type="text" class="form-control" name="line_of_business">';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        foreach($field[1] as $check_key => $check) {

                                                                            if($check_key == 5) {

                                                                                echo '<div class="col-lg-6">';
                                                                                    echo '<div class="icheck-primary">';
                                                                                        echo '<input type="checkbox" name="tax_checklist[]" id="check'.$field_key.$check_key.'" value="5">';
                                                                                        echo '<label for="check'.$field_key.$check_key.'">'.renderLang($check).'</label>';
                                                                                        echo '<input type="text" name="tax_specify" class="form-control mt-2">';
                                                                                    echo '</div>';
                                                                                echo '</div>';

                                                                            } else {

                                                                                echo '<div class="col-lg-6">';
                                                                                    echo '<div class="icheck-primary">';
                                                                                        echo '<input type="checkbox" name="tax_checklist[]" id="check'.$field_key.$check_key.'" value="'.$check_key.'">';
                                                                                        echo '<label for="check'.$field_key.$check_key.'">'.renderLang($check).'</label>';
                                                                                    echo '</div>';
                                                                                echo '</div>';

                                                                            }
                                                                            
                                                                        }

                                                                    break;

                                                                    case 'C':

                                                                        echo '<div class="col-12">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.$key.$field_key.'. '.renderLang($field[0]).'</label>';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        foreach($field[1] as $check_key => $check) {

                                                                            if($check_key == 1) {

                                                                                // NOTIVCE TO THE PUBLIC DISPLAY no
                                                                                echo '<div class="col-lg-6">';
                                                                                    echo '<div class="form-group clearfix">';
                                                                                        echo '<div class="icheck-danger d-inline">';
                                                                                            echo '<input type="radio" id="notice_public_display_no" name="notice_public_display" value="0" checked>';
                                                                                            echo '<label for="notice_public_display_no">'.renderLang($check).'</label>';
                                                                                        echo '</div>';
                                                                                    echo '</div>';
                                                                                echo '</div>';

                                                                                // NOTIVCE TO THE PUBLIC DISPLAY SPECIFY
                                                                                echo '<div class="col-lg-6">';
                                                                                    echo '<div class="form-group">';
                                                                                        echo '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                                                                        echo '<input type="text" class="form-control" name="notice_public_display_specify">';
                                                                                    echo '</div>';
                                                                                echo '</div>';

                                                                            } else {

                                                                                // NOTIVCE TO THE PUBLIC DISPLAY yes
                                                                                echo '<div class="col-12">';
                                                                                    echo '<div class="form-group clearfix">';
                                                                                        echo '<div class="icheck-success d-inline">';
                                                                                            echo '<input type="radio" id="notice_publc_display_yes" name="notice_public_display" value="1">';
                                                                                            echo '<label for="notice_publc_display_yes">'.renderLang($check).'</label>';
                                                                                        echo '</div>';
                                                                                    echo '</div>';
                                                                                echo '</div>';
                                                                            }
                                                                        }

                                                                    break;

                                                                    case 'D':
                                                                        // ANNUAL REGISTRATION
                                                                        echo '<div class="col-12">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.$key.$field_key.'. '.renderLang($field[0]).'</label>';
                                                                                echo '<input type="text" name="annual_registration" class="form-control">';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        echo '<div class="col-5">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.renderLang($pre_operation_audit_pcc_amount).'</label>';
                                                                                echo '<input type="text" name="bir_amount" class="form-control"  data-type="currency">';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        echo '<div class="col-5">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.renderLang($pre_operation_audit_pad_checklist_date_paid).'</label>';
                                                                                echo '<input type="text" name="bir_date_paid" class="form-control date">';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                    break;
                                                                }

                                                            }
                                                        }

                                                        if($key == '2') {

                                                            foreach($value['fields'] as $field_key => $field) {

                                                                echo '<div class="col-md-4">';
                                                                    echo '<div class="form-group">';
                                                                        echo '<label for="">'.renderLang($field).'</label>';
                                                                        echo '<input type="text" name="sec_value[]" class="form-control '.($field_key == 1 ? 'date' : '').'" value="">';
                                                                        echo '<input type="hidden" name="sec_category[]" value="'.$field_key.'">';
                                                                    echo '</div>';
                                                                echo '</div>';

                                                            }

                                                        }

                                                        if($key == '3') {

                                                            foreach($value['fields'] as $field_key => $field) {

                                                                switch($field_key) {

                                                                    case 'A':

                                                                        // BUSINESS PERMIT NO.
                                                                        echo '<div class="col-md-4">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.$key.$field_key.'. '.renderLang($field[0]).'</label>';
                                                                                echo '<input type="text" class="form-control" name="business_permit_number">';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        echo '<div class="col-md-4">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.renderLang($pre_operation_audit_pcc_date).'</label>';
                                                                                echo '<input type="text" class="form-control date" name="lg_date">';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        foreach($field[1] as $check_key => $check) {

                                                                            // LOCAL GOVERMENT DISPLAY 
                                                                            echo '<div class="col-12">';
                                                                                echo '<div class="form-group">';
                                                                                    echo '<div class="icheck-'.($check_key == 0 ? 'success' : 'danger').' d-inline">';
                                                                                        echo '<input type="radio" id="check'.$field_key.$check_key.$key.'" name="lg_display" value="'.$check_key.'" '.($check_key == 1 ? 'checked' : '').'>';
                                                                                        echo '<label for="check'.$field_key.$check_key.$key.'">'.renderLang($check).'</label>';
                                                                                    echo '</div>';
                                                                                echo '</div>';
                                                                            echo '</div>';

                                                                        }

                                                                    break;

                                                                    case 'B':

                                                                        echo '<div class="col-12 mt-4">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.$key.$field_key.'. '.renderLang($field[0]).'</label>';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        foreach($field[1] as $check_key => $check) {

                                                                            echo '<div class="col-lg-6">';
                                                                                echo '<div class="form-group">';
                                                                                    echo '<label for="">'.renderLang($check).'</label>';
                                                                                    echo '<input type="text" '.($check_key == 3 ? 'data-type="currency"' : '').' class="form-control '.($check_key == 1 ? 'date' : '').'" name="lg_value[]">';
                                                                                    echo '<input type="hidden" name="lg_number_category[]" value="0'.$check_key.'">';
                                                                                echo '</div>';
                                                                            echo '</div>';
                                                                        }

                                                                    break;

                                                                    case 'C':

                                                                        echo '<div class="col-12 mt-4">';
                                                                            echo '<div class="form-group">';
                                                                                echo '<label for="">'.$key.$field_key.'. '.renderLang($field[0]).'</label>';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        foreach($field[1] as $check_key => $check) {

                                                                            echo '<div class="col-lg-6">';
                                                                                echo '<div class="form-group">';
                                                                                    echo '<label for="">'.renderLang($check).'</label>';
                                                                                    echo '<input type="text" '.($check_key == 3 ? 'data-type="currency"' : '').' class="form-control '.($check_key == 1 ? 'date' : '').'" name="lg_value[]">';
                                                                                    echo '<input type="hidden" name="lg_number_category[]" value="1'.$check_key.'">';
                                                                                echo '</div>';
                                                                            echo '</div>';
                                                                        }

                                                                    break;

                                                                }

                                                            }
                                                            echo '<hr>';
                                                            echo '<div class="col-12">';
                                                                echo '<div class="form-group">';
                                                                    echo '<div class="icheck-primary">';
                                                                        echo '<input type="checkbox" name="inhouse" id="inhouse" value="1" checked>';
                                                                        echo '<label for="inhouse">In house</label>';
                                                                    echo '</div>';
                                                                echo '</div>';
                                                            echo '</div>';

                                                        }

                                                        if($key == '4') {

                                                            foreach($value['fields'] as $field_key => $field) {

                                                                echo '<div class="col-md-4">';
                                                                    echo '<div class="form-group">';
                                                                        echo '<label for="">'.renderLang($field).'</label>';
                                                                        echo '<input type="text" class="form-control" name="sss_value[]">';
                                                                        echo '<input type="hidden" class="form-control" name="sss_category[]" value="'.$field_key.'">';
                                                                    echo '</div>';
                                                                echo '</div>';

                                                            }

                                                            echo '<div class="col-md-4 row">';
                                                                echo '<div class="col-12">';
                                                                    echo '<div class="form-group">';
                                                                        echo '<label for="">('.renderLang($pre_operation_audit_pad_pls_attach_copy).')</label>';
                                                                        echo '<input type="file" class="form-control" name="attachments1[]" multiple>';
                                                                        echo '<input type="hidden" class="form-control" name="attachment_category[]" value="A4">';
                                                                        echo '<input type="hidden" name="accounting_remarks[]">';
                                                                    echo '</div>';
                                                                echo '</div>';
                                                            echo '</div>';

                                                        }

                                                        if($key == '5') {

                                                            foreach($value['fields'] as $field_key => $field) {

                                                                echo '<div class="col-md-4">';
                                                                    echo '<div class="form-group">';
                                                                        echo '<label for="">'.renderLang($field).'</label>';
                                                                        echo '<input type="text" class="form-control" name="pap_value[]">';
                                                                        echo '<input type="hidden" name="pap_category[]" value="0'.$field_key.'">';
                                                                    echo '</div>';
                                                                echo '</div>';

                                                            }

                                                        }

                                                        if($key == '6') {

                                                            foreach($value['fields'] as $field_key => $field) {

                                                                echo '<div class="col-md-4">';
                                                                    echo '<div class="form-group">';
                                                                        echo '<label for="">'.renderLang($field).'</label>';
                                                                        echo '<input type="text" class="form-control" name="pap_value[]">';
                                                                        echo '<input type="hidden" name="pap_category[]" value="1'.$field_key.'">';
                                                                    echo '</div>';
                                                                echo '</div>';

                                                            }

                                                        }
                                                        ?>

                                                    </div>

                                                    <?php if($key < 4) { ?>
                                                    <div class="col-lg-4 row">
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="A<?php echo $key; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>

                                                    </div>

                                                    <?php } ?>

                                                </div>
                                                <hr>

                                                <?php
                                                if ($key == '4' || $key == '5' || $key == '6') {

                                                        echo '</div>';

                                                    }
                                                    $num = $key;
                                                }

                                                $num++;
                                                ?>

                                                <div class="row">
                                                    <div class="col-8 row">
                                                        <div class="col-12">
                                                            <h4><?php echo $num.'. '.renderLang($pre_operation_audit_others); ?></h4>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_specify); ?></label>
                                                                <input type="text" class="form-control" name="others">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- B. BOOKS OF ACCOUNTS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-B" aria-expanded="false" aria-controls="collapseExample">B. <?php echo renderLang($pad_turnover_audit_checklist_arr['B']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-B">

                                            <div class="card card-body">

                                                <?php 
                                                foreach($pad_turnover_audit_checklist_B_arr as $key => $value) {
                                                ?>
                                                <div class="row">

                                                    <?php 
                                                    echo '<div class="col-lg-8 border-right row">';

                                                    foreach($value as $field_key => $field) {


                                                        if($key == 0) {

                                                        echo '<div class="col-md-6">';
                                                                echo '<div class="icheck-primary">';
                                                                    echo '<input type="checkbox" id="check'.$field_key.$key.'" name="books_types[]" value="'.$field_key.'">';
                                                                    echo '<label for="check'.$field_key.$key.'">'.renderLang($field).'</label>';
                                                                echo '</div>';
                                                            echo '</div>';

                                                            echo '<br><br>';

                                                        }
                                                        
                                                        if($key == 1) {

                                                            echo '<div class="col-md-6 mb-4">';
                                                                echo '<div class="form-group">';
                                                                    echo '<label for="">'.renderLang($field).'</label>';
                                                                    echo '<input type="text" class="form-control '.($field_key == 0 || $field_key == 3 ? 'date' : '').'" name="boa_value[]">';
                                                                    echo '<input type="hidden" name="boa_category[]" value="'.$field_key.'">';
                                                                echo '</div>';
                                                            echo '</div>';

                                                        }

                                                        if($key == 2) {

                                                            echo '<div class="col-lg-4">';
                                                            if ($field_key == 0) { echo '<label></label>'; }
                                                                echo '<div class="icheck-primary '.($field_key == 7 || $field_key == 6 ? 'ml-5' : '').'">';
                                                                    echo '<input type="checkbox" class="bcheck" id="check'.$field_key.$key.'" value="1">';
                                                                    echo '<input type="hidden" class="bvalue" name="boa_status[]" value="0">';
                                                                    echo '<label for="check'.$field_key.$key.'">'.renderLang($field).'</label>';
                                                                echo '</div>';
                                                            echo '</div>';
                                                                    echo '<input type="hidden" name="books_of_accounts_type[]" value="'.$field_key.'">';

                                                            echo '<div class="col-lg-4">';
                                                                if ($field_key == 0) {
                                                                    echo '<label>Date From-To</label>';
                                                                }
                                                                echo '<div>';
                                                                    echo '<input type="text" class="form-control date-range" name="books_of_account_date_from_to[]"">';
                                                                echo '</div>';
                                                            echo '</div>';

                                                            echo '<div class="col-lg-4">';
                                                                if ($field_key == 0) {
                                                                    echo '<label>Date Received</label>';
                                                                }
                                                                echo '<div>';
                                                                    echo '<input type="text" class="form-control date" name="books_of_account_date_received[]">';
                                                                echo '</div>';
                                                            echo '</div>';

                                                        }

                                                    }

                                                        if($key == 2) {

                                                            echo '<div class="col-lg-4">';
                                                                echo '<input type="text" class="form-control" name="boa_status[]" placeholder="Others">';
                                                                echo '<input type="hidden" name="books_of_accounts_type[]" value="999">';
                                                            echo '</div>';

                                                            echo '<div class="col-lg-4">';
                                                                echo '<div>';
                                                                    echo '<input type="text" class="form-control date-range" name="books_of_account_date_from_to[]">';
                                                                echo '</div>';
                                                            echo '</div>';

                                                            echo '<div class="col-lg-4">';
                                                                echo '<div>';
                                                                    echo '<input type="text" class="form-control date" name="books_of_account_date_received[]">';
                                                                echo '</div>';
                                                            echo '</div>';
                                                        }

                                                    echo '</div>';
                                                    ?>

                                                    <?php if($key == 1) { ?>
                                                    <div class="col-lg-4 row">
                                                        
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="B1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>

                                                    </div>
                                                    <?php } ?>

                                                </div>
                                                <?php } ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- C. TAX COMPLIANCE REVIEW -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-C" aria-expanded="false" aria-controls="collapseExample">C. <?php echo renderLang($pad_turnover_audit_checklist_arr['C']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-C">

                                            <div class="card card-body">

                                                <?php 
                                                foreach($pad_turnover_audit_checklist_C_arr as $key => $value) {
                                                ?>
                                                        
                                                <div class="row">
                                                    <div class='col-12'>
                                                        <h4><?php echo $key.'. '.renderLang($value['title']); ?></h4>
                                                    </div>
                                                    <div class="col-lg-8 border-right">
                                                    <?php 
                                                        // NIRC
                                                        if($key == 1) {

                                                            echo '<div class="table-responsive">';

                                                                echo '<table class="table">';
                                                                    echo '<thead>';
                                                                        echo '<tr>';
                                                                            echo '<th class="w300"></th>';
                                                                            echo '<th>'.renderLang($pre_operation_audit_pad_return).'</th>';
                                                                            echo '<th>'.renderLang($pre_operation_audit_pad_remitted).'</th>';
                                                                        echo '</tr>';
                                                                    echo '</thead>';
                                                                foreach($value['fields'] as $field_key => $field) {
                                                                    
                                                                    echo '<tr>';

                                                                    // checkbox
                                                                    echo '<td>';
                                                                        echo '<div class="icheck-primary">';
                                                                            echo '<input type="checkbox" class="gcheck" id="'.$key.$field_key.'" value="1">';
                                                                            echo '<input type="hidden" class="gvalue" name="nirc_status[]" value="0">';
                                                                            echo '<label for="'.$key.$field_key.'">'.renderLang($field).'</label>';
                                                                        echo '</div>';
                                                                    echo '</td>';

                                                                    echo '<td><input type="text" class="form-control" name="latest_return_filed[]"></td>';

                                                                    echo '<td><input type="text" class="form-control date border-0" name="date_filed_remitted[]"></td>';

                                                                    echo '<input type="hidden" name="nirc_types[]" value="'.$field_key.'">';

                                                                    echo '</tr>';

                                                                }
                                                                    echo '<tbody id="c-other">';
                                                                        echo '<tr class="default-row">';
                                                                        // checkbox
                                                                        echo '<td><input type="text" class="form-control" name="nirc_status[]" placeholder="Others"></td>';

                                                                        echo '<td><input type="text" class="form-control" name="latest_return_filed[]"></td>';

                                                                        echo '<td><input type="text" class="form-control date border-0" name="date_filed_remitted[]"></td>';

                                                                        echo '<td class="d-none"><input type="hidden" name="nirc_types[]" value="999"></td>';

                                                                        echo '</tr>';
                                                                    echo '</tbody>';
                                                                    echo '<tfoot>';
                                                                        echo '<tr>';
                                                                            echo '<td colspan="3" class="text-right">';
                                                                                echo '<button type="button" class="btn btn-sm btn-info add-row-c"><i class="fa fa-plus mr-1"></i>'. renderLang($lang_add_row).'</button>';
                                                                            echo '</td>';
                                                                        echo '</tr>';
                                                                    echo '</tfoot>';
                                                                echo '</table>';

                                                            echo '</div>';

                                                        }
                                                        // REAL ESTATE TAX
                                                        if($key == 2) {

                                                            echo '<div class="table-responsive">';

                                                            foreach($value['fields'] as $field_key => $field) {
                                                                echo '<table class="table">';

                                                                    echo '<tbody>';

                                                                        echo '<tr>';
                                                                            echo '<th colspan="4">'.renderLang($field).'</th>';
                                                                        echo '</tr>';
                                                                    
                                                                        echo '<tr class="default-row-ret">';

                                                                            echo '<td>';
                                                                                echo '<label class="ml-3">'.renderLang($pre_operation_audit_period_covered).'</label>';
                                                                                echo '<input type="text" class="form-control" name="ret_period_covered[]">';
                                                                            echo '</td>';

                                                                            echo '<td>';
                                                                                echo '<label class="ml-3">'.renderLang($pre_operation_audit_pcc_amount).'</label>';
                                                                                echo '<input type="text" data-type="currency" class="form-control" name="ret_amount[]">';
                                                                            echo '</td>';

                                                                            echo '<td>';
                                                                                echo '<label class="ml-3">'.renderLang($daily_collections_daily_collection_voucher_type).'</label>';
                                                                                echo '<input type="text" class="form-control" name="ret_reference[]">';
                                                                            echo '</td>';

                                                                            echo '<input type="hidden" class="form-control" name="ret_category[]" value="'.$key.$field_key.'">';

                                                                        echo '</tr>';

                                                                    echo '</tbody>';
                                                                    echo '<tfoot>';

                                                                        echo '<tr>';
                                                                            echo '<td colspan="3" class="text-right">';
                                                                                echo '<button type="button" class="btn btn-sm btn-info add-row-ret"><i class="fa fa-plus mr-1"></i>'. renderLang($lang_add_row).'</button>';
                                                                            echo '</td>';
                                                                        echo '</tr>';

                                                                    echo '</tfoot>';

                                                                echo '</table>';
                                                            }
                                                            
                                                            echo '</div>';

                                                        }
                                                    ?>
                                                    </div>

                                                    <div class="col-lg-4 row">
                                                        
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="C<?php echo $key; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>

                                                    </div>

                                                </div>
                                                
                                                <?php } ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- D. TAX COMPLIANCE REVIEW -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-D" aria-expanded="false" aria-controls="collapseExample">D. <?php echo renderLang($pad_turnover_audit_checklist_arr['D']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-D">

                                            <div class="card card-body">

                                                <div class="row">
                                                    <div class="col-lg-8 row">

                                                    <?php 
                                                    foreach($pad_turnover_audit_checklist_D_arr as $key => $value) {
                                                    ?>

                                                        <div class='col-12'>
                                                            <h4>
                                                                <?php echo $key.'. '.renderLang($value); ?>
                                                                <input type="hidden" name="budgets_types[]" value="<?php echo $key; ?>">
                                                            </h4>
                                                        </div>

                                                        <div class="col-lg-12 border-right">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <tr>
                                                                        <th><?php echo renderLang($pre_operation_audit_date_of_approval); ?></th>
                                                                        <td><input type="text" class="form-control date" name="budgets_date_approval[]"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><?php echo renderLang($pre_operation_audit_assessment_rate); ?></th>
                                                                        <td><input type="text" class="form-control" name="budgets_assesment_rate[]"></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                    </div>

                                                    <div class="col-lg-4 row">
                                                                
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="D1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                                

                                        </div>
                                    </div>
                                </div>

                                <!-- E. SCHEDULE OF ASSESSMENTS, DUES & DEPOSITS  -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-E" aria-expanded="false" aria-controls="collapseExample">E. <?php echo renderLang($pad_turnover_audit_checklist_arr['E']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-E">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-8">

                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
                                                                foreach($pad_turnover_audit_checklist_E_arr as $key => $value) {

                                                                    if($key == '1.0') {
                                                                        echo '<tr>';
                                                                            echo '<td><p>'.$key.' '.renderLang($value[0]).'</p><input type="hidden" name="sadd_types[]" value="'.$key.'"></td>';
                                                                            echo '<td><input type="text" class="form-control" name="sadd_description[]" va></td>';
                                                                        echo '</tr>';

                                                                        foreach($value[1] as $sub_1_key => $sub_1) {

                                                                            echo '<tr>';
                                                                                echo '<td><p class="ml-2">'.$sub_1_key.' '.renderLang($sub_1[0]).'</p><input type="hidden" name="sadd_types[]" value="'.$key.$sub_1_key.'"></td>';
                                                                                echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                            echo '</tr>';

                                                                            if($sub_1_key == '1.1') {

                                                                                foreach($sub_1[1] as $sub_2_key => $sub_2) {

                                                                                    echo '<tr class="'.($sub_2_key == '1.1.1' ? 'show10' : '' ).''.($sub_2_key == '1.1.2' ? 'show20' : '' ).' '.($sub_2_key != '1.1.3' ? 'd-none' : '' ).' ">';
                                                                                        echo '<td><p class="ml-3">'.$sub_2_key.' '.renderLang($sub_2).'</p><input type="hidden" name="sadd_types[]" value="'.$key.$sub_1_key.$sub_2_key.'"></td>';
                                                                                        echo '<td><input type="text" class="form-control name="sadd_description[]"></td>';
                                                                                    echo '</tr>';
        
                                                                                }

                                                                            }

                                                                            if($sub_1_key == '1.2') {

                                                                                foreach($sub_1[1] as $sub_2_key => $sub_2) {

                                                                                    echo '<tr>';
                                                                                        echo '<td><p class="ml-3">'.$sub_2_key.' '.renderLang($sub_2[0]).'</p><input type="hidden" name="sadd_types[]" value="'.$key.$sub_1_key.$sub_2_key.'"></td>';
                                                                                        echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                                    echo '</tr>';

                                                                                    if($sub_2_key == '1.2.1') {

                                                                                        foreach($sub_2[1] as $sub_3_key => $sub_3) {

                                                                                            echo '<tr>';
                                                                                                echo '<td><p class="ml-4">'.$sub_3_key.'. '.renderLang($sub_3[0]).'</p><input type="hidden" name="sadd_types[]" value="'.$key.$sub_1_key.$sub_2_key.$sub_3_key.'"></td>';
                                                                                                echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                                            echo '</tr>';

                                                                                            if($sub_3_key == 'a') {

                                                                                                foreach($sub_3[1] as $sub_4_key => $sub_4) {

                                                                                                    echo '<tr>';
                                                                                                        echo '<td><p class="ml-5"> - '.renderLang($sub_4).'</p><input type="hidden" name="sadd_types[]" value="'.$key.$sub_1_key.$sub_2_key.$sub_3_key.$sub_4_key.'"></td>';
                                                                                                        echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                                                    echo '</tr>';

                                                                                                }

                                                                                            }

                                                                                        }

                                                                                    }

                                                                                    if($sub_2_key == '1.2.2') {
                                                                                        
                                                                                        foreach($sub_2[1] as $sub_3_key => $sub_3) {

                                                                                            echo '<tr>';
                                                                                                echo '<td><p class="ml-4">'.$sub_3_key.'. '.renderLang($sub_3).'</p><input type="hidden" name="sadd_types[]" value="'.$key.$sub_1_key.$sub_2_key.$sub_3_key.'"></td>';
                                                                                                echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                                            echo '</tr>';

                                                                                        }

                                                                                    }

                                                                                }

                                                                            }

                                                                        }
                                                                    }

                                                                    if($key == '2.0' || $key == '3.0') {
                                                                        echo '<tr>';
                                                                            echo '<td><p>'.$key.' '.renderLang($value).'</p><input type="hidden" name="sadd_types[]" value="'.$key.'"></td>';
                                                                            echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                        echo '</tr>';
                                                                    }

                                                                }
                                                                ?>
                                                                <tr class="default-row">
                                                                    <td><input type="text" class="form-control" name="sadd_types[]" placeholder="Others"></td>
                                                                    <td><input type="text" class="form-control" name="sadd_description[]"></td>
                                                                </tr>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="3" class="text-right">
                                                                            <button type="button" class="btn btn-sm btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-4 row">
                                                                
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="E1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        
                                                        </div>

                                                    </div>


                                                </div>

                                            </div>

                                                

                                        </div>
                                    </div>
                                </div>

                                <!-- F. ACCOUNTING FORMS  -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-F" aria-expanded="false" aria-controls="collapseExample">F. <?php echo renderLang($pad_turnover_audit_checklist_arr['F']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-F">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-8">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th><?php echo renderLang($pre_operation_audit_numbered); ?></th>
                                                                        <th><?php echo renderLang($pre_operation_audit_numbered_as_used); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <?php 
                                                                foreach($pad_turnover_audit_checklist_F_arr as $key => $value) {

                                                                 echo '<tbody>';
                                                                    echo '<tr>';

                                                                        // checkbox
                                                                        echo '<td>';
                                                                        echo '<input type="hidden" name="accounting_forms_types[]" value="'.$key.'">';
                                                                            echo '<div class="icheck-primary">';
                                                                                echo '<input type="checkbox" class="gcheck" id="F'.$key.'" value="1">';
                                                                                echo '<input type="hidden" class="gvalue" name="af_status[]" value="0">';
                                                                                echo '<label for="F'.$key.'">'.renderLang($value).'</label>';
                                                                            echo '</div>';
                                                                        echo '</td>';

                                                                        echo '<td><input type="text" class="form-control" name="accounting_forms_numbered[]"></td>';
                                                                        echo '<td><input type="text" class="form-control" name="accounting_forms_numbered_as_used[]"></td>';

                                                                    echo '</tr>';

                                                                    echo '<tr>';
                                                                    echo '<td><label>Remarks:</label></td>';
                                                                    echo '<td colspan="2"><input type="text" class="form-control" name="accounting_forms_remarks[]"></td>';
                                                                    echo '</tr>';
                                                                echo '</tbody>';

                                                                }
                                                                ?>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 row">
                                                                
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="F1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>

                                                    </div>

                                                </div>

                                            </div>  

                                        </div>
                                    </div>
                                </div>

                                <!-- G. FINANCIAL MANAGEMENT REPORTING -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-G" aria-expanded="false" aria-controls="collapseExample">G. <?php echo renderLang($pad_turnover_audit_checklist_arr['G']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-G">
                                            
                                            <div class="card card-body">

                                                <div class="row">
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Latest Report Submitted</th>
                                                                        <th>Date Submitted</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    foreach($pad_turnover_audit_checklist_G_arr as $key => $value) {
                                                                        
                                                                        echo '<tr>';

                                                                        // checkbox
                                                                        echo '<td>';
                                                                            echo '<div class="icheck-primary">';
                                                                                echo '<input type="checkbox" class="gcheck" id="G'.$key.'" value="1">';
                                                                                echo '<input type="hidden" class="gvalue" name="fmr_status[]" value="0">';
                                                                                echo '<label for="G'.$key.'">'.renderLang($value).'</label>';
                                                                            echo '</div>';
                                                                            echo '<input type="hidden" name="financial_types[]" value="'.$key.'">';
                                                                        echo '</td>';

                                                                        echo '<td><input type="text" class="form-control" name="financial_latest_report_submitted[]"></td>';
                                                                        echo '<td><input type="text" class="form-control" name="financial_date_submitted[]"></td>';
                                                                        echo '</tr>';

                                                                            if ($key == 6 || $key == 7) {
                                                                                foreach ($aging_account_arr[$key] as $field_key => $value) {
                                                                                    echo '<tr>';
                                                                                    echo '<div class="form-group clearfix">';
                                                                                        echo '<td class="border-0"><label class="ml-5">'.renderLang($value).' :</label></td>';
                                                                                            foreach ($yesno_arr as $yesno_key => $yesno) {

                                                                                                echo '<td class="border-0">';
                                                                                                echo '<div class="icheck-'.($yesno_key == 0 ? 'danger' : 'success').'">';
                                                                                                    echo '<input type="radio" id="'.$key.$field_key.$yesno_key.'" name="status_'.$key.$field_key.'" value="'.$yesno_key.'" '.($yesno[0] == 0 ? 'checked' : '').'>';
                                                                                                    echo ' <label for="'.$key.$field_key.$yesno_key.'">'.renderLang($yesno[1]).'</label>';
                                                                                                echo '</div>';
                                                                                                echo '</td>';

                                                                                            }

                                                                                        echo '<input type="hidden" name="fmr_types[]" value="'.$key.$field_key.'">';

                                                                                    echo '</div>';
                                                                                    echo '</tr>';
                                                                                }
                                                                            }

                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="3"><label><?php echo renderLang($pre_operation_audit_others).' '.renderLang($pre_operation_audit_specify); ?></label></td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="text" class="form-control" name="fmr_status[]"></td>
                                                                        <td><input type="text" class="form-control" name="financial_latest_report_submitted[]"></td>
                                                                        <td><input type="text" class="form-control" name="financial_date_submitted[]"></td>
                                                                        <input type="hidden" name="financial_types[]" value="999">
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 row">
                                                                
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="G1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- H. CASH OH HAND  -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-H" aria-expanded="false" aria-controls="collapseExample">H. <?php echo renderLang($pad_turnover_audit_checklist_arr['H']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-H">

                                            <div class="card card-body">

                                                <div class="row">
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <?php 
                                                                $num = 1;
                                                                foreach($pad_turnover_audit_checklist_H_arr as $key => $value) {

                                                                    echo '<tr>';

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="cash_on_hand_types[]" value="'.$key.'"></td>';
                                                                    echo '<td><input type="text" data-type="currency" class="form-control" name="cash_on_hand_amount[]"></td>';

                                                                    echo '</tr>';

                                                                    $num++;

                                                                }
                                                                ?>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 row">     
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="H1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- I. BANK ACCOUNTS AND RELATED DOCUMENTS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-I" aria-expanded="false" aria-controls="collapseExample">I. <?php echo renderLang($pad_turnover_audit_checklist_arr['I']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-I">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-8">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <?php 
                                                                $num = 1;
                                                                foreach($pad_turnover_audit_checklist_I_arr as $key => $value) {

                                                                    echo '<tr>';

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="bank_accounts_types[]" value="'.$key.'"></td>';
                                                                    echo '<td><input type="text" class="form-control" name="bank_accounts_description[]"></td>';

                                                                    echo '</tr>';

                                                                    $num++;

                                                                }
                                                                ?>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 row">     
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="I1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- J. BILLING FORMULA WITH SUPPORTING SUBSIDIARY LEDGERS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-J" aria-expanded="false" aria-controls="collapseExample">J. <?php echo renderLang($pad_turnover_audit_checklist_arr['J']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-J">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-8">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <?php 
                                                                $num = 1;
                                                                foreach($pad_turnover_audit_checklist_J_arr as $key => $value) {

                                                                    echo '<tr>';

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="billing_formula_types[]" value="'.$key.'"></td>';
                                                                    echo '<td><input type="text" class="form-control" name="billing_formula_description[]"></td>';

                                                                    echo '</tr>';

                                                                    $num++;

                                                                }
                                                                ?>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 row">     
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="J1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- K. UNPAID INVOICES -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-K" aria-expanded="false" aria-controls="collapseExample">K. <?php echo renderLang($pad_turnover_audit_checklist_arr['K']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-K">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-8">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <?php 
                                                                $num = 1;
                                                                foreach($pad_turnover_audit_checklist_K_arr as $key => $value) {

                                                                    echo '<tr>';

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="unpaid_invoices_types[]" value="'.$key.'"></td>';
                                                                    echo '<td><input type="text" class="form-control" name="unpaid_invoices_description[]"></td>';

                                                                    echo '</tr>';

                                                                    $num++;

                                                                }
                                                                ?>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 row">     
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="K1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- L. CERTIFICATE OF DEPOSITS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-L" aria-expanded="false" aria-controls="collapseExample">L. <?php echo renderLang($pad_turnover_audit_checklist_arr['L']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-L">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-8">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <?php 
                                                                $num = 1;
                                                                foreach($pad_turnover_audit_checklist_L_arr as $key => $value) {

                                                                    echo '<tr>';

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="certificate_deposit_types[]" value="'.$key.'"></td>';
                                                                    echo '<td><input type="text" class="form-control" name="certificate_deposit_description[]"></td>';

                                                                    echo '</tr>';

                                                                    $num++;

                                                                }
                                                                ?>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 row">     
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="L1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- M. LIST OF PENDING ACCOUNTING PROJECTS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-M" aria-expanded="false" aria-controls="collapseExample">M. <?php echo renderLang($pad_turnover_audit_checklist_arr['M']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-M">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-8 row">

                                                        <div class="col-12">
                                                            <h5>(<?php echo renderLang($pre_operation_audit_pad_checklist_m_reminder); ?>)</h5>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><p>1. <?php echo renderLang($pre_operation_audit_outstanding_bir_cases); ?></p><input type="text" class="form-control" name="pending_account_projects[]"></td>
                                                                        </tr>
                                                                        <tr class="default-row">
                                                                            <td><input type="text" class="form-control" name="pending_account_projects[]"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="2" class="text-right">
                                                                                <button type="button" class="btn btn-sm btn-info add-row-m"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-4 row">     
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="M1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- N. EXISTING INTERNAL ACCOUNTING PROCEDURES OTHER THAN  -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-N" aria-expanded="false" aria-controls="collapseExample">N. <?php echo renderLang($pad_turnover_audit_checklist_arr['N']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-N">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <label for="">Remarks</label>
                                                            <input type="text" class="form-control" name="accounting_remarks[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <label for=""><?php echo renderLang($pre_operation_audit_pad_pls_attach_copy); ?></label>
                                                            <input type="file" class="form-control" name="attachments2[]" multiple>
                                                            <input type="hidden" name="attachment_category[]" value="N1">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 row">     
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="N1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- O. ACCOUNTING FUNCTIONS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-O" aria-expanded="false" aria-controls="collapseExample">O. <?php echo renderLang($pad_turnover_audit_checklist_arr['O']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-O">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <label for="">Remarks</label>
                                                            <input type="text" class="form-control" name="accounting_remarks[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <label for=""><?php echo renderLang($pre_operation_audit_pad_pls_attach_copy); ?> (<?php echo renderLang($pre_operation_audit_attach_function); ?>)</label>
                                                            <input type="file" class="form-control" name="attachments3[]" multiple>

                                                            <input type="hidden" name="attachment_category[]" value="O1">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 row">     
                                                        <div class="col-12 ml-3">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_takeover_by); ?></label>
                                                                <input type="text" class="form-control" name="turnover_takeover_by[]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_pad_accepted_by); ?></label>
                                                                <input type="text" class="form-control" name="accepted_by[]">

                                                                <input type="hidden" name="parent_id[]" value="O1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea type="text" class="form-control notes" name="notes[]"></textarea>
                                                            </div>                                                        
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- P. OTHER MATTERS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-p" aria-expanded="false" aria-controls="collapseExample">P. <?php echo renderLang($pad_turnover_audit_checklist_arr['P']); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-p">

                                            <div class="card card-body">

                                                <div class="row">

                                                    <div class="col-12">
                                                        <label><?php echo renderLang($pad_turnover_audit_checklist_arr['P']); ?></label>
                                                        <textarea class="form-control notes" name="other_matters"></textarea>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- CREDITS -->
                                <div class="row">
                                    <?php
                                    foreach ($pre_ops_pad_checklist_credit_types as $key => $credit_types) {

                                        echo '<div class="col-12">';
                                            echo '<div class="table-responsive">';
                                                echo '<table class="table table-bordered">';
                                                    echo '<thead>';
                                                       echo '<tr>';
                                                            echo '<th>'.renderLang($credit_types).'</th>';
                                                            echo '<th>'.renderLang($pre_operation_audit_date_of_inspection).'</th>';
                                                            echo '<th>'.renderLang($pre_operation_audit_signature).'</th>';
                                                        echo '</tr>';
                                                    echo '</thead>';
                                                    echo '<tbody>';
                                                        echo '<tr class="default-row">';
                                                            echo '<td><input type="text" class="form-control border-0" name="credit_by[]"></td>';
                                                            echo '<td><input type="text" class="form-control date border-0" name="credit_date[]"></td>';
                                                            echo '<td><input type="text" class="form-control border-0" name="credit_signature[]"></td>';
                                                            echo '<td class="d-none"><input type="hidden" name="credit_category[]" value="'.$key.'"></td>';
                                                        echo '</tr>';
                                                    echo '</tbody>';
                                                    echo '<tfoot>';
                                                        echo '<tr>';
                                                            echo '<td colspan="3" class="text-right">';
                                                                echo '<button type="button" class="btn btn-sm btn-info add-row"><i class="fa fa-plus mr-1"></i>'.renderLang($lang_add_row).'</button>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                    echo '</tfoot>';
                                                echo '</table>';
                                            echo '</div>';
                                        echo '</div>';
                                    } 
                                    ?>  
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/pad-pre-operation-audit-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($pre_operation_audit_pad_save_checklist); ?></button>
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
  <script>
    $(function(){

        $('.date').each(function(){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

        $('.date-range').each(function(){
                $(this).daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });

        // show A. 4,5 and 6 row
            $('#inhouse').on('change', function(){

                var val = $(this).val();

                if(!$(this).is(':checked')) {
                    $('.show456').addClass('d-none');
                }
                else {
                    $('.show456').removeClass('d-none');
                }
            });

        // M. add row
        $('body').on('click', '.add-row-m', function(e){
            e.preventDefault();

            var fields = '<tr>'+$(this).closest('table').find('.default-row').html()+'</tr>';
            $(this).closest('table').find('tbody').append(fields);

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });

        });

        $('body').on('click', '.add-row', function(e){
            e.preventDefault();

            var fields = '<tr>'+$(this).closest('table').find('.default-row').html()+'</tr>';
            $(this).closest('table').find('tbody').append(fields);

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });

        });

        $('body').on('click', '.add-row-c', function(e){
            e.preventDefault();

            var fields = '<tr>'+$(this).closest('table').find('.default-row').html()+'</tr>';
            $(this).closest('table').find('#c-other').append(fields);

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });

        });


        $('body').on('click', '.add-row-ret', function(e){
            e.preventDefault();

            var fields2 = '<tr>'+$(this).closest('table').find('.default-row-ret').html()+'</tr>';
            $(this).closest('table').find('tbody').append(fields2);

        });

        // change save status 
        $('body').on('change', '.gcheck', function(){

            if($(this).is(':checked')) {
                $(this).closest('div').find('.gvalue').val('1');


            } else {
                $(this).closest('div').find('.gvalue').val('0');
            }

        });

        // change save status 
        $('body').on('change', '.bcheck', function(){

            if($(this).is(':checked')) {
                $(this).closest('div').find('.bvalue').val('1');


            } else {
                $(this).closest('div').find('.bvalue').val('0');
            }

        });

        // show E
        $('#check10').on('change', function(){

            var val = $(this).val();

            if(!$(this).is(':checked')) {
                $('.show10').addClass('d-none');
            }
            else {
                $('.show10').removeClass('d-none');
            }
        });

        // show E
        $('#check20').on('change', function(){

            var val = $(this).val();

            if(!$(this).is(':checked')) {
                $('.show20').addClass('d-none');
            }
            else {
                $('.show20').removeClass('d-none');
            }
        });

        // show E
        $('#check30').on('change', function(){

            var val = $(this).val();

            if(!$(this).is(':checked')) {
                $('.show30').addClass('d-none');
            }
            else {
                $('.show30').removeClass('d-none');
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

