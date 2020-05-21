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
                                                                                    echo '<input type="file" class="form-control" name="bir_attachment[]" multiple>';
                                                                                echo '</div>';
                                                                            echo '</div>';
                                                                        echo '</div>';

                                                                        foreach($field[1] as $check_key => $check) {

                                                                            if($check_key == 1) {

                                                                                // BIR DISPLAY NO
                                                                                echo '<div class="col-lg-6">';
                                                                                    echo '<div class="form-group">';
                                                                                        echo '<div class="custom-control custom-radio">';
                                                                                            echo '<input class="custom-control-input" type="radio" id="bir_display_no" name="bir_display" value="0" checked>';
                                                                                            echo '<label for="bir_display_no" class="custom-control-label">'.renderLang($check).'</label>';
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
                                                                                    echo '<div class="form-group">';
                                                                                        echo '<div class="custom-control custom-radio">';
                                                                                            echo '<input class="custom-control-input" type="radio" id="bir_display_yes" name="bir_display" value="1">';
                                                                                            echo '<label for="bir_display_yes" class="custom-control-label">'.renderLang($check).'</label>';
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
                                                                                    echo '<div class="form-group">';
                                                                                        echo '<div class="custom-control custom-radio">';
                                                                                            echo '<input class="custom-control-input" type="radio" id="notice_public_display_no" name="notice_public_display" value="0" checked>';
                                                                                            echo '<label for="notice_public_display_no" class="custom-control-label">'.renderLang($check).'</label>';
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
                                                                                    echo '<div class="form-group">';
                                                                                        echo '<div class="custom-control custom-radio">';
                                                                                            echo '<input class="custom-control-input" type="radio" id="notice_publc_display_yes" name="notice_public_display" value="1">';
                                                                                            echo '<label for="notice_publc_display_yes" class="custom-control-label">'.renderLang($check).'</label>';
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
                                                                    break;
                                                                }

                                                            }
                                                        }

                                                        if($key == '2') {

                                                            foreach($value['fields'] as $field_key => $field) {

                                                                echo '<div class="col-md-4">';
                                                                    echo '<div class="form-group">';
                                                                        echo '<label for="">'.renderLang($field).'</label>';
                                                                        echo '<input type="text" name="sec_'.$field_key.'" class="form-control '.($field_key == 1 ? 'date' : '').'">';
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
                                                                                    echo '<div class="custom-control custom-radio">';
                                                                                        echo '<input class="custom-control-input" type="radio" id="check'.$field_key.$check_key.$key.'" name="lg_display" value="'.$check_key.'" '.($check_key == 1 ? 'checked' : '').'>';
                                                                                        echo '<label for="check'.$field_key.$check_key.$key.'" class="custom-control-label">'.renderLang($check).'</label>';
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
                                                                                    echo '<input type="text" '.($check_key == 3 ? 'data-type="currency"' : '').' class="form-control '.($check_key == 1 ? 'date' : '').'" name="local_gov_'.$check_key.'[]">';
                                                                                echo '</div>';
                                                                            echo '</div>';


                                                                        }
                                                                            echo '<input type="hidden" name="local_gov_category[]" value="Community Tax Certificate">';

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
                                                                                    echo '<input '.($check_key == 3 ? 'data-type="currency"' : '').' type="text" class="form-control '.($check_key == 1 ? 'date' : '').'" name="local_gov_'.$check_key.'[]">';
                                                                                echo '</div>';
                                                                            echo '</div>';


                                                                        }
                                                                            echo '<input type="hidden" name="local_gov_category[]" value="Barangay Clearance">';

                                                                    break;

                                                                }

                                                            }
                                                            echo '<hr>';
                                                            echo '<div class="col-12">';
                                                                echo '<div class="form-group">';
                                                                    echo '<div class="icheck-primary">';
                                                                        echo '<input type="checkbox" name="inhouse" id="inhouse" value="1">';
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
                                                                        echo '<input type="text" class="form-control" name="sss_'.$field_key.'">';
                                                                    echo '</div>';
                                                                echo '</div>';

                                                            }

                                                            echo '<div class="col-md-4 row">';
                                                                echo '<div class="col-12">';
                                                                    echo '<div class="form-group">';
                                                                        echo '<label for="">('.renderLang($pre_operation_audit_pad_pls_attach_copy).')</label>';
                                                                        echo '<input type="file" class="form-control" name="sss_attachment[]" multiple>';
                                                                    echo '</div>';
                                                                echo '</div>';
                                                            echo '</div>';

                                                        }

                                                        if($key == '5') {

                                                            foreach($value['fields'] as $field_key => $field) {

                                                                echo '<div class="col-md-4">';
                                                                    echo '<div class="form-group">';
                                                                        echo '<label for="">'.renderLang($field).'</label>';
                                                                        echo '<input type="text" class="form-control" name="pap_'.$field_key.'[]">';
                                                                    echo '</div>';
                                                                echo '</div>';

                                                            }

                                                            echo '<input type="hidden" name="pap_category[]" value="PHILHEALTH">';

                                                        }

                                                        if($key == '6') {

                                                            foreach($value['fields'] as $field_key => $field) {

                                                                echo '<div class="col-md-4">';
                                                                    echo '<div class="form-group">';
                                                                        echo '<label for="">'.renderLang($field).'</label>';
                                                                        echo '<input type="text" class="form-control" name="pap_'.$field_key.'[]">';
                                                                    echo '</div>';
                                                                echo '</div>';

                                                            }

                                                            echo '<input type="hidden" name="pap_category[]" value="HOME DEVELOPMENT MUTUAL FUND (Pag-ibig)">';

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
                                                                    echo '<input type="text" class="form-control '.($field_key == 0 || $field_key == 3 ? 'date' : '').'" name="boa_'.$field_key.'">';
                                                                echo '</div>';
                                                            echo '</div>';

                                                        }

                                                        if($key == 2) {

                                                            echo '<div class="col-lg-4">';
                                                            if ($field_key == 0) {
                                                                    echo '<label></label>';
                                                                }
                                                                echo '<div class="icheck-primary">';
                                                                    echo '<input type="checkbox" id="check'.$field_key.$key.'" name="books_of_accounts_type[]" value="'.$field_key.'">';
                                                                    echo '<label for="check'.$field_key.$key.'">'.renderLang($field).'</label>';
                                                                echo '</div>';
                                                            echo '</div>';

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
                                                            echo '<div class="icheck-primary">';
                                                                echo '<input type="checkbox" name="check" id="check'.$field_key.$key.'other" name="books_of_accounts_type[]" value="5">';
                                                                echo '<label for="check'.$field_key.$key.'other">'.renderLang($pre_operation_audit_others).'</label>';
                                                                echo '<div class="form-group mt-1">';
                                                                    echo '<input type="text" class="form-control" name="books_of_accounts_type_others">';
                                                                echo '</div>';
                                                            echo '</div>';
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
                                                                            echo '<input type="checkbox" id="'.$key.$field_key.'" name="nirc_types[]" value="'.$field_key.'">';
                                                                            echo '<label for="'.$key.$field_key.'">'.renderLang($field).'</label>';
                                                                        echo '</div>';
                                                                    echo '</td>';

                                                                    echo '<td><input type="text" class="form-control" name="latest_return_filed[]"></td>';

                                                                    echo '<td><input type="text" class="form-control date border-0" name="date_filed_remitted[]"></td>';

                                                                    echo '</tr>';

                                                                }
                                                                    echo '<tbody id="c-other">';
                                                                        echo '<tr class="default-row">';
                                                                        // checkbox
                                                                        echo '<td><input type="text" class="form-control" name="nirc_types[]" placeholder="Others"></td>';

                                                                        echo '<td><input type="text" class="form-control" name="latest_return_filed[]"></td>';

                                                                        echo '<td><input type="text" class="form-control date border-0" name="date_filed_remitted[]"></td>';

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
                                                                            echo '<th colspan="4">'.renderLang($field).'<input type="hidden" name="ret_types[]" value="'.renderLang($field).'"></th>';
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

                                                                            echo '<input type="hidden" class="form-control" name="ret_category[]" value="'.$field_key.'">';

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
                                                                <input type="hidden" name="budgets_types[]" value="<?php echo renderLang($value); ?>">
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
                                                                            echo '<td><p>'.$key.' '.renderLang($value[0]).'</p><input type="hidden" name="sadd_types[]" value="'.renderLang($value[0]).'"></td>';
                                                                            echo '<td><input type="text" class="form-control" name="sadd_description[]" va></td>';
                                                                        echo '</tr>';

                                                                        foreach($value[1] as $sub_1_key => $sub_1) {

                                                                            echo '<tr>';
                                                                                echo '<td><p class="ml-2">'.$sub_1_key.' '.renderLang($sub_1[0]).'</p><input type="hidden" name="sadd_types[]" value="'.renderLang($sub_1[0]).'"></td>';
                                                                                echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                            echo '</tr>';

                                                                            if($sub_1_key == '1.1') {

                                                                                foreach($sub_1[1] as $sub_2_key => $sub_2) {

                                                                                    echo '<tr>';
                                                                                        echo '<td><p class="ml-3">'.$sub_2_key.' '.renderLang($sub_2).'</p><input type="hidden" name="sadd_types[]" value="'.renderLang($sub_2).'"></td>';
                                                                                        echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                                    echo '</tr>';
        
                                                                                }

                                                                            }

                                                                            if($sub_1_key == '1.2') {

                                                                                foreach($sub_1[1] as $sub_2_key => $sub_2) {

                                                                                    echo '<tr>';
                                                                                        echo '<td><p class="ml-3">'.$sub_2_key.' '.renderLang($sub_2[0]).'</p><input type="hidden" name="sadd_types[]" value="'.renderLang($sub_2[0]).'"></td>';
                                                                                        echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                                    echo '</tr>';

                                                                                    if($sub_2_key == '1.2.1') {

                                                                                        foreach($sub_2[1] as $sub_3_key => $sub_3) {

                                                                                            echo '<tr>';
                                                                                                echo '<td><p class="ml-4">'.$sub_3_key.' '.renderLang($sub_3[0]).'</p><input type="hidden" name="sadd_types[]" value="'.renderLang($sub_3[0]).'"></td>';
                                                                                                echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                                            echo '</tr>';

                                                                                            if($sub_3_key == 'a') {

                                                                                                foreach($sub_3[1] as $sub_4_key => $sub_4) {

                                                                                                    echo '<tr>';
                                                                                                        echo '<td><p class="ml-5"> - '.renderLang($sub_4).'</p><input type="hidden" name="sadd_types[]" value="'.renderLang($sub_4).'"></td>';
                                                                                                        echo '<td><input type="text" class="form-control" name="sadd_description[]"></td>';
                                                                                                    echo '</tr>';

                                                                                                }

                                                                                            }

                                                                                        }

                                                                                    }

                                                                                    if($sub_2_key == '1.2.2') {
                                                                                        
                                                                                        foreach($sub_2[1] as $sub_3_key => $sub_3) {

                                                                                            echo '<tr>';
                                                                                                echo '<td><p class="ml-4">'.$sub_3_key.' '.renderLang($sub_3).'</p><input type="hidden" name="sadd_types[]" value="'.renderLang($sub_3).'"></td>';
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
                                                                            echo '<td><p>'.$key.' '.renderLang($value).'</p><input type="hidden" name="sadd_types[]" value="'.renderLang($value).'"></td>';
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
                                                            </div>                                                        </div>

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
                                                                        <th>Acknowledgement Receipt</th>
                                                                    </tr>
                                                                </thead>
                                                                <?php 
                                                                foreach($pad_turnover_audit_checklist_F_arr as $key => $value) {

                                                                 echo '<tbody>';
                                                                    echo '<tr>';

                                                                        // checkbox
                                                                        echo '<td>';
                                                                            echo '<div class="icheck-primary">';
                                                                                echo '<input type="checkbox" id="F'.$key.'" name="accounting_forms_types[]" value="'.$key.'">';
                                                                                echo '<label for="F'.$key.'">'.renderLang($value).'</label>';
                                                                            echo '</div>';
                                                                        echo '</td>';

                                                                        echo '<td><input type="text" class="form-control" name="accounting_forms_numbered[]"></td>';
                                                                        echo '<td><input type="text" class="form-control" name="accounting_forms_numbered_as_used[]"></td>';
                                                                        echo '<td><input type="text" class="form-control" name="acknowledgement_receipt[]"></td>';

                                                                    echo '</tr>';

                                                                    echo '<tr>';
                                                                    echo '<td><label>Remarks:</label></td>';
                                                                    echo '<td colspan="3"><input type="text" class="form-control" name="accounting_forms_remarks[]"></td>';
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
                                                                                echo '<input type="checkbox" id="G'.$key.'" name="financial_types[]" value="'.$key.'">';
                                                                                echo '<label for="G'.$key.'">'.renderLang($value).'</label>';
                                                                            echo '</div>';
                                                                        echo '</td>';

                                                                        echo '<td><input type="text" class="form-control" name="financial_latest_report_submitted[]"></td>';
                                                                        echo '<td><input type="text" class="form-control" name="financial_date_submitted[]"></td>';

                                                                        echo '</tr>';

                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="3"><label><?php echo renderLang($pre_operation_audit_others).' '.renderLang($pre_operation_audit_specify); ?></label></td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="text" class="form-control" name="financial_types[]"></td>
                                                                        <td><input type="text" class="form-control" name="financial_latest_report_submitted[]"></td>
                                                                        <td><input type="text" class="form-control" name="financial_date_submitted[]"></td>
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

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="cash_on_hand_types[]" value="'.renderLang($value).'"></td>';
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

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="bank_accounts_types[]" value="'.renderLang($value).'"></td>';
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

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="billing_formula_types[]" value="'.renderLang($value).'"></td>';
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

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="unpaid_invoices_types[]" value="'.renderLang($value).'"></td>';
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
                                                            </div>                                                        </div>
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

                                                                    echo '<td><p>'.$num.'. '.renderLang($value).'</p><input type="hidden" name="certificate_deposit_types[]" value="'.renderLang($value).'"></td>';
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
                                                            <input type="file" class="form-control" name="accounting_attachments0[]" multiple>
                                                            <input type="hidden" name="accounting_category[]" value="N">
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
                                                            <input type="file" class="form-control" name="accounting_attachments1[]" multiple>

                                                            <input type="hidden" name="accounting_category[]" value="O">
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
                                                            </div>                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- CREDITS -->
                                <div class="row">

                                    <!-- INSPECTED BY -->
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo renderLang($pre_operation_audit_inspected_by); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_date_of_inspection); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_signature); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="default-row">
                                                        <td><input type="text" class="form-control border-0" name="inspected_by[]"></td>
                                                        <td><input type="text" class="form-control date border-0" name="date_inspect[]"></td>
                                                        <td><input type="text" class="form-control border-0" name="inspect_signature[]"></td>
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

                                    <!-- ACKNOWLEDGE BY -->
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo renderLang($pre_operation_audit_pcc_acknowledge_by); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_date_of_inspection); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_signature); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="default-row">
                                                        <td><input type="text" class="form-control border-0" name="acknowledge_by[]"></td>
                                                        <td><input type="text" class="form-control date border-0" name="date_acknowledge[]"></td>
                                                        <td><input type="text" class="form-control border-0" name="acknowledge_signature[]"></td>
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

                                    <!-- WITNESSED BY -->
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo renderLang($pre_operation_audit_witnessed_by); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_date_of_inspection); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_signature); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="default-row">
                                                        <td><input type="text" class="form-control border-0" name="witnessed_by[]"></td>
                                                        <td><input type="text" class="form-control date border-0" name="date_witness[]"></td>
                                                        <td><input type="text" class="form-control border-0" name="witness_signature[]"></td>
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

                                    <!-- NOTED BY -->
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo renderLang($pre_operation_audit_noted_by); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_date_of_inspection); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_signature); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="default-row">
                                                        <td><input type="text" class="form-control border-0" name="noted_by[]"></td>
                                                        <td><input type="text" class="form-control date border-0" name="date_note[]"></td>
                                                        <td><input type="text" class="form-control border-0" name="note_signature[]"></td>
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
                                    
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/pre-operation-audit-pad-categories" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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

                if($(this).is(':checked')) {
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

