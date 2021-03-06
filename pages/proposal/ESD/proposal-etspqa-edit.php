<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    // check permission to access this page or function
    if(checkPermission('proposal-esd-add')) {

        // clear sessions from forms
        clearSessions();

        // set page
        $page = 'proposal';

        // get suggested reference number
        $suggested_reference_number = '';
        $date_code = date('ymd');
        $sql = $pdo->prepare("SELECT id, reference_number FROM proposal_esd_tsa UNION SELECT id, reference_number FROM proposal_esd_generic UNION SELECT id, reference_number FROM proposal_esd_etspqa ORDER BY id DESC LIMIT 1");
        $sql->execute();
        if($sql->rowCount()) {
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
            $reference_number = explode('-', $_data['reference_number']);
            $reference_id = (int)$reference_number[2] + 1;
            $suggested_reference_number = $reference_number[0].'-'.$date_code.'-'.$reference_id;
        } else {
            $suggested_reference_number = 'ESD-'.$date_code.'-100001';
        }

        $etspqaQ = $pdo->query("SELECT * FROM proposal_esd_etspqa WHERE id = ".$_GET['id']);
        $etspqa = $etspqaQ->fetch(PDO::FETCH_ASSOC);


        function numToLettering($num) {
            $alphabet = range('A','Z');
            if ($num > 0 && $num <= 26) {
                return $alphabet[$num - 1];
            } else {
                $dividend = ($num);
                $returnStr = '';
                $modulo = 0;
                while ($dividend > 0) {
                    $modulo = ($dividend - 1) % 26;
                    $returnStr = $alphabet[$modulo] . $returnStr;
                    $dividend = floor((($dividend - $modulo) / 26));
                }
                return $returnStr;
            }
        }
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title><?php echo renderLang($generic_proposal_esd_add); ?> &middot; <?php echo $sitename; ?></title>

            <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
            <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
            <style>
                input[type=number]::-webkit-inner-spin-button,
                input[type=number]::-webkit-outer-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }
            </style>
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
                                <h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($etspqa_proposal_esd_edit); ?></h1>
                            </div>
                        </div>

                    </div><!-- container-fluid -->
                </section><!-- content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">

                        <form method="post" action="/submit-add-esd-etspqa-proposal">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo renderLang($esd_technical_and_safety_audit); ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="projectName" >Proposal Status</label>
                                                <select class="form-control" id="proposalStatus" name="status" required>
                                                    <option value="">&nbsp;</option>
                                                    <?php
                                                    // prospecting category = 0:BDD, 1:ESD, 2:POD
                                                    // status = 0:active, 1:inactive, 2:declined by fpd, 3:closed, 4:declined by client
                                                    foreach ($proposal_esd_status_arr as $esdNum => $esdStatus) {
                                                        if ($esdNum == $etspqa['status']) $active = 'selected=selected'; else $active = '';
                                                        ?>
                                                        <option value="<?= $esdNum ?>" <?= $active ?>><?= renderLang($esdStatus) ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="projectName" >Project Name</label>
                                                <select class="form-control select2" id="projectName" name="prospect_id" required>
                                                    <option value="">&nbsp;</option>
                                                    <?php
                                                    // prospecting category = 0:BDD, 1:ESD, 2:POD
                                                    // status = 0:active, 1:inactive, 2:declined by fpd, 3:closed, 4:declined by client
                                                    $sql = $pdo->prepare("SELECT p.project_name, p.id FROM prospecting p WHERE p.status = 3 AND p.prospecting_category = 1 AND p.temp_del = 0");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        if ($etspqa['prospect_id']==$data['id']) $active="selected=selected"; else $active = "";
                                                        echo '<option value="'.$data['id'].'" '.$active.'>'.$data['project_name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <label>Reference Number</label>
                                            <input type="text" class="form-control" id="referenceNo" name="reference_number" value="<?= is_null($etspqa['reference_number']) ? "" : $etspqa['reference_number'] ?>" readonly>
                                        </div>
                                        <div class="col-3">
                                            <label>Date</label>
                                            <input type="text" class="form-control date" id="longDate" name="date" value="<?= is_null($etspqa['date']) ? "" : date("d F Y",strtotime($etspqa['clientName'])) ?>" required/>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-3 pt-3">
                                                    <label>Company/Client Name</label>
                                                    <input type="text" class="form-control mb-1" id="clientName" name="clientName" placeholder="Client Name" required value="<?= $etspqa['clientName'] ?>"/>
                                                    <br />
                                                    <label>Address</label>
                                                    <input type="text" class="form-control mb-1" id="addressLine1" name="address_line1" placeholder="Line 1" required value="<?= $etspqa['address_line1'] ?>"/>
                                                    <input type="text" class="form-control mb-1" id="addressLine2" name="address_line2" placeholder="Line 2" required value="<?= $etspqa['address_line2'] ?>"/>
                                                    <br />
                                                    <label>Payment Terms</label>
                                                    <textarea class="form-control" placeholder="Payment Terms" id="paymentTerms" name="payment_terms" required><?= $etspqa['payment_terms'] ?></textarea>
                                                    <br />
                                                    <label>Proposal Validity</label>
                                                    <textarea class="form-control" placeholder="Proposal Validity" id="proposalValidity" name="validity_period" required><?= $etspqa['validity_period'] ?></textarea>
                                                    <br />
                                                    <label>Signatory</label>
                                                    <?php
                                                    $department = '';
                                                    if ($_SESSION['sys_account_mode'] == "employee") {
                                                        $department = getField('department_name', 'departments JOIN employees ON(departments.id = employees.department_id)', 'employees.id = '.$_SESSION['sys_id']);
                                                    }
                                                    ?>
                                                    <input type="text" class="form-control mb-1" id="signatoryName" name="signatoryName" placeholder="Name" value="<?= $etspqa['signatoryName'] ?>" required/>
                                                    <input type="text" class="form-control mb-1" id="signatoryPosition" name="signatoryPosition" placeholder="Position" value="<?= $etspqa['signatoryPosition'] ?>" required/>
                                                    <input type="text" class="form-control mb-1" id="signatoryDepartment" name="signatoryDepartment" placeholder="Department" value="<?= $etspqa['signatoryDepartment'] ?>" required/>
                                                    <br />
                                                    <label>Conforme</label>
                                                    <input type="text" class="form-control mb-1" id="conformeSignatoryName" placeholder="Name" required value="<?= $etspqa['conformeSignatoryName'] ?>"/>
                                                    <input type="text" class="form-control mb-1" id="conformeSignatoryContact" placeholder="Contact" required value="<?= $etspqa['conformeSignatoryName'] ?>"/>
                                                    <br />
                                                    <label>Letter Subject</label>
                                                    <input type="text" class="form-control mb-1" id="letterSubject" name="letter_subject" placeholder="Letter Subject" required value="<?= $etspqa['letter_subject'] ?>"/>
                                                    <br />
                                                    <span style="font-size: 18px">Other objectives, scope of works and tasks can be appended below, see second page.</span>
                                                </div>
                                                <div class="col-9" style="border-left: 1px solid gray">
                                                    <div class="row">
                                                        <div class="col-12 p-3">
                                                            <b>LETTER PREVIEW (Min. 2 Pages) &nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                        </div>
                                                        <div class="col-12 pt-2 pl-3" style="">
                                                            <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                    <div class="col-10">
                                                                        Ref. No. <span class="bg-gray-light pl-2 pr-2 referenceNoPreview" data-toggle="tooltip" data-placement="top" title="Reference Number"><?= $etspqa['reference_number'] ?></span>
                                                                        <br /><br />
                                                                        <span class="bg-gray-light pl-2 pr-2 longDatePreview" data-toggle="tooltip" data-placement="top" title="Long Date"><?= is_null($etspqa['date']) || $etspqa['date'] == "" ? "[Long Date]" : date("d F Y", strtotime($etspqa['clientName'])) ?></span>
                                                                        <br /><br /><br />
                                                                        <span class="bg-gray-light pl-2 pr-2" id="clientNamePreview" data-toggle="tooltip" data-placement="top" title="Company/Client Name"><?= is_null($etspqa['clientName']) || $etspqa['clientName'] == "[Company/Client Name]" ? "" : $etspqa['clientName'] ?></span><br />
                                                                        <span class="bg-gray-light pl-2 pr-2" id="addressLine1Preview" data-toggle="tooltip" data-placement="top" title="Address Line 1"><?= is_null($etspqa['address_line1']) || $etspqa['address_line1'] == "" ? "[Address Line 1]" : $etspqa['address_line1'] ?></span><br />
                                                                        <span class="bg-gray-light pl-2 pr-2" id="addressLine2Preview" data-toggle="tooltip" data-placement="top" title="Address Line 2"><?= is_null($etspqa['address_line2']) || $etspqa['address_line2'] == "" ? "[Address Line 2]" : $etspqa['address_line2'] ?></span><br /><br /><br />
                                                                    </div>
                                                                    <div class="col-2 text-right">
                                                                        <img src="/assets/images/Company%20Logo.png" style="width: 100%"/>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <p class="text-justify">Greetings!</p>
                                                                        <p class="text-justify">FPD Asia Property Services, Inc., would like to offer our Engineering Services for Electrical Thermal Scanning & Power Quality Audit. We specialize in the management of commercial and office buildings, residential condominiums, engineering facilities, manufacturing plants, retail developments (malls), resorts, villages and subdivisions. We also offer engineering and technical services to fit all your properties’ needs and requirements.</p>
                                                                        <p class="text-justify">FPD Asia will provide a professional maintenance team, tools, materials and equipment necessary to the completion of the proposed service within ten (10) working days after receipt of approved purchase order.</p>
                                                                        <p class="text-justify">Our fee for the said service is <span class="bg-gray-light pl-2 pr-2" id="paymentTermsPreview" data-toggle="tooltip" data-placement="top" title="Payment Terms"><?= is_null($etspqa['payment_terms']) || $etspqa['payment_terms'] == "" ? "" : $etspqa['payment_terms'] ?></span> inclusive of VAT. Our offered terms of payment is full payment upon completion of works.  The proposal shall be valid for <span class="bg-gray-light pl-2 pr-2" id="proposalValidityPreview" data-toggle="tooltip" data-placement="top" title="Proposal Validity"><?= is_null($etspqa['validity_period']) || $etspqa['validity_period'] == "" ? "" : $etspqa['validity_period'] ?></span>.</p>
                                                                        <p class="text-justify">Please find the attached specific scope of work to be rendered.</p>
                                                                        <p class="text-justify">Should you find our proposal acceptable, kindly sign below to signify your conformity to the abovementioned and fax to 815 2915 or email to esdteam@fpdasia.net.  If you need clarification of our proposed services, do not hesitate to contact us.</p>
                                                                        <br /><br />
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>Very truly yours,</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>Noted By</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>
                                                                            <span class="bg-gray-light pl-2 pr-2 signatoryNamePreview" data-toggle="tooltip" data-placement="top" title="Signatory Name"><?= is_null($etspqa['signatoryName']) || $etspqa['signatoryName'] == "" ? "" : $etspqa['signatoryName'] ?></span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 signatoryPositionPreview" data-toggle="tooltip" data-placement="top" title="Signatory Position"><?= is_null($etspqa['signatoryPosition']) || $etspqa['signatoryPosition'] == "" ? "" : $etspqa['signatoryPosition'] ?></span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 signatoryDepartmentPreview" data-toggle="tooltip" data-placement="top" title="Signatory Department"><?= is_null($etspqa['signatoryDepartment'])  || $etspqa['signatoryDepartment'] == ""? "" : $etspqa['signatoryDepartment'] ?></span>
                                                                        </p>
                                                                        <br /><br />
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>
                                                                            ENGR. EMELITO A. ADIA <br />
                                                                            Director<br />
                                                                            Engineering Services Division
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>CONFORME</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>
                                                                            <span class="bg-gray-light pl-2 pr-2" id="conformeSignatoryNamePreview" data-toggle="tooltip" data-placement="top" title="Conforme Signatory Name"><?= is_null($etspqa['conformeSignatoryName']) || $etspqa['conformeSignatoryName'] == "" ? "[Conforme Signatory Name]" : $etspqa['conformeSignatoryName'] ?></span><br />
                                                                            Contact: <span class="bg-gray-light pl-2 pr-2" id="conformeSignatoryContactPreview" data-toggle="tooltip" data-placement="top" title="Conforme Signatory Contact"><?= is_null($etspqa['conformeSignatoryContact']) || $etspqa['conformeSignatoryContact'] == "" ? "[Conforme Signatory Contact]" : $etspqa['conformeSignatoryContact'] ?></span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br />
                                                            <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                    <div class="col-10">
                                                                        Ref. No. <span class="bg-gray-light pl-2 pr-2 referenceNoPreview" data-toggle="tooltip" data-placement="top" title="Reference Number"><?php echo $suggested_reference_number; ?></span>
                                                                        <br /><br />
                                                                        <span class="bg-gray-light pl-2 pr-2 longDatePreview" data-toggle="tooltip" data-placement="top" title="Long Date"><?= is_null($etspqa['date']) ? "[Long Date]" : date("d F Y", strtotime($etspqa['date'])) ?></span>
                                                                        <br /><br /><br />
                                                                        Subject: Electrical Thermal Scanning & Power Quality Audit<br /><br /><br />
                                                                    </div>
                                                                    <div class="col-2 text-right">
                                                                        <img src="/assets/images/Company%20Logo.png" style="width: 100%"/>
                                                                    </div>
                                                                    <div class="col-12 thermalScanning">
                                                                        <p class="text-justify"><b>THERMAL SCANNING</b></p>
                                                                        <div id="objectives">
                                                                            <?php
                                                                                $etspqaObjQ = $pdo->query("SELECT * FROM proposal_esd_etspqa_ts_objectives WHERE proposal_id = ".$etspqa['id']);
                                                                                $etspqaObj = $etspqaObjQ->fetchAll(PDO::FETCH_ASSOC);
                                                                                $etspqaObjCtr = 1;
                                                                                foreach ($etspqaObj as $objectives) {
                                                                            ?>
                                                                            <div class="input-group pl-5 objective" style="position: relative; top: -5px;">
                                                                                <div class="input-group-prepend" style="position: relative; top: 5px;">
                                                                                    <span class="objectiveCtr"><?= $etspqaObjCtr ?></span>.
                                                                                </div>
                                                                                <textarea type="text" class="form-control-plaintext" name="objective[]" placeholder="Objective" style="padding-left: 5px;" required><?= $objectives['objective'] ?></textarea>
                                                                                <div class="input-group-append">
                                                                                    <button class="btn bg-none btnDeleteObjective" type="button">
                                                                                        <i class="fa fa-trash-alt text-gray"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <?php $etspqaObjCtr+=1; } ?>
                                                                            <?php if ($etspqaObjQ->rowCount()==0) { ?>
                                                                                <div class="input-group pl-5 objective" style="position: relative; top: -5px;">
                                                                                    <div class="input-group-prepend" style="position: relative; top: 5px;">
                                                                                        <span class="objectiveCtr">1</span>.
                                                                                    </div>
                                                                                    <textarea type="text" class="form-control-plaintext" name="objective[]" placeholder="Objective" style="padding-left: 5px;" required></textarea>
                                                                                    <div class="input-group-append">
                                                                                        <button class="btn bg-none btnDeleteObjective" type="button">
                                                                                            <i class="fa fa-trash-alt text-gray"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            <?php }?>
                                                                            <button class="btn btn-block bg-gray-light text-gray" id="btbAddNewObjective" type="button">Add New Objective</button>
                                                                        </div>
                                                                        <br /><br />
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <p class="text-justify"><b>Scope of Work:</b></p>
                                                                        <div class="scopeOfWorks">
                                                                                <?php
                                                                                    $etspqaScopeQ = $pdo->query("SELECT * FROM proposal_esd_etspqa_scopes WHERE proposal_id = ".$etspqa['id']. " ORDER BY number asc");
                                                                                    $etspqaScopes = $etspqaScopeQ->fetchAll(PDO::FETCH_ASSOC);
                                                                                    $etspqaScopesCtr = 0;
                                                                                    foreach ($etspqaScopes as $scopes) {
                                                                                ?>
                                                                                <div class="row scopeOfWork pb-3">
                                                                                    <div class="col-12">
                                                                                        <div class="row">
                                                                                            <div class="col-12 input-group scopeOfWorkName pb-3">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><?= numToLettering($etspqaScopesCtr+1) ?>.</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" name="scope[<?= $etspqaScopesCtr ?>][scope]" placeholder="Scope of Work Name" required value="<?= $scopes['scope'] ?>"/>
                                                                                                <div class="input-group-append">
                                                                                                    <button class="btn bg-gray-light btnDeleteScope" type="button">
                                                                                                        <i class="fa fa-trash-alt text-gray"></i>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-12 pl-5 tasks">
                                                                                                <?php
                                                                                                $etspqaTaskQ = $pdo->query("SELECT * FROM proposal_esd_etspqa_tasks WHERE scope_id = ".$scopes['id']. " ORDER BY number asc");
                                                                                                $etspqaTasks = $etspqaTaskQ->fetchAll(PDO::FETCH_ASSOC);
                                                                                                $etspqaTasksCtr = 0;
                                                                                                foreach ($etspqaTasks as $tasks) {
                                                                                                ?>
                                                                                                <div class="input-group task pb-3 task">
                                                                                                    <div class="input-group-prepend">
                                                                                                        <span class="input-group-text taskCtr"><?= $etspqaTasksCtr+1 ?></span>
                                                                                                    </div>
                                                                                                    <input type="text" class="form-control" value="<?= $tasks['task'] ?>" name="scope[<?= $etspqaScopesCtr ?>][scope][task][<?= $etspqaTasksCtr ?>]" placeholder="Task Name" required/>
                                                                                                    <div class="input-group-append">
                                                                                                        <button class="btn bg-gray-light btnDeleteTask" type="button">
                                                                                                            <i class="fa fa-trash-alt text-gray"></i>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <button class="btn btn-block bg-gray-light text-gray btnAddNewTask" type="button">Add New Task</button>
                                                                                                <?php $etspqaTasksCtr+=1; }?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php $etspqaScopesCtr+=1; } ?>
                                                                            <button class="btn btn-block bg-gray-light text-gray" id="btnAddNewScopeOfWork" type="button">Add New Scope of Work</button>
                                                                        </div>
                                                                        <br /><br />
                                                                    </div>
                                                                    <div class="col-12 powerQualityAudit">
                                                                        <p class="text-justify"><b>POWER QUALITY AUDIT</b></p>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Scope of Work</span>
                                                                            </div>
                                                                            <textarea id="pqaScopeOfWork" name="pqaScopeOfWork" class="form-control"></textarea>
                                                                        </div>
                                                                        <Br />
                                                                        <div id="powerQualityItems">
                                                                        <div class="row powerQualityItem pb-3">
                                                                            <div class="col-12">
                                                                                <div class="row">
                                                                                    <div class="col-12 input-group powerQualityItemName pb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"><span class="pqaItemCtr">1</span>.</span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control" name="pqa[0][item]" placeholder="Item Name" required/>
                                                                                        <div class="input-group-append">
                                                                                            <button class="btn bg-gray-light btnDeletePQAItem" type="button">
                                                                                                <i class="fa fa-trash-alt text-gray"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12 pl-5 powerQualitySubItems">
                                                                                        <div class="input-group task pb-3 powerQualitySubItem">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text"><span class="pqaSICtr">1.1</span>.</span>
                                                                                            </div>
                                                                                            <input type="text" class="form-control" name="pqa[0][item][subItem][0]" placeholder="Sub-item Name" required/>
                                                                                            <div class="input-group-append">
                                                                                                <button class="btn bg-gray-light btnDeletePQASubItem" type="button">
                                                                                                    <i class="fa fa-trash-alt text-gray"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <button class="btn btn-block bg-gray-light text-gray btnAddNewPQASubItem" type="button">Add New Sub-Item</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn btn-block bg-gray-light text-gray" id="btnAddNewPQAItem" type="button">Add New Item</button>
                                                                    </div>
                                                                        <br /><br />
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>Very truly yours,</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>Noted By</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>
                                                                            <span class="bg-gray-light pl-2 pr-2 signatoryNamePreview" data-toggle="tooltip" data-placement="top" title="Signatory Name"><?php echo getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']); ?></span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 signatoryPositionPreview" data-toggle="tooltip" data-placement="top" title="Signatory Position">[Signatory Position]</span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 signatoryDepartmentPreview" data-toggle="tooltip" data-placement="top" title="Signatory Department"><?= is_null($department) || $department == "" ? "[Signatory Department]" : $department ?></span>
                                                                        </p>
                                                                        <br /><br />
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p>
                                                                            ENGR. EMELITO A. ADIA<br />
                                                                            Director<br />
                                                                            Engineering Services Division
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- status -->
                                    <div class="row mt-5">
                                        <div class="col-12 text-right">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="save-status" name="status" value="0">
                                                <label for="save-status"><?php echo renderLang($lang_save_as_draft); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="/esd-generic-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right mr-1"></i><?php echo renderLang($btn_submit); ?></button>
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
        <script src="/plugins/moment/moment.min.js"></script>
        <script src="/plugins/daterangepicker/daterangepicker.js"></script>
        <script>
            $(function(){

                // datepicker
                $('.date').daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('[data-toggle=tooltip]').tooltip();

                $('#longDate').on('change', function () {
                    let d = new Date(Date.parse($('#longDate').val()));

                    const months = [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December'
                    ];

                    if (d.getDate() + " " + months[d.getMonth()] + " " + d.getFullYear() == "NaN undefined NaN") {
                        $('.longDatePreview').html("[Long Date]");
                    } else {
                        $('.longDatePreview').html(d.getDate() + " " + months[d.getMonth()] + " " + d.getFullYear());
                    }
                }).on("focus", function () {
                    $('.longDatePreview').addClass('bg-gray-dark');
                    $('.longDatePreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('.longDatePreview').addClass('bg-gray-light');
                    $('.longDatePreview').removeClass('bg-gray-dark');
                });

                // Scope and Task Name Organizer
                function organizeScopeAndTask() {
                    let scopeCtr = 0;
                    $('.scopeOfWorks').find('.scopeOfWork').each(function() {
                       $(this).find('.scopeOfWorkName .input-group-prepend .input-group-text').html(provideLetteringNumber(scopeCtr+1) + ".");
                       $(this).find('.scopeOfWorkName input').attr('name','scope['+ scopeCtr +'][name]');
                       taskCtr = 0;
                       $(this).find('.tasks').find('.task').each(function() {
                           $(this).find('input').attr('name','scope['+scopeCtr+'][tasks]['+taskCtr+']');
                           $(this).find('.taskCtr').html(taskCtr+1);
                           taskCtr+=1;
                       });
                        scopeCtr+=1;
                    });
                }

                organizeScopeAndTask();

                // Objectives

                $('#btbAddNewObjective').click(function() {
                    let objective = $(this).closest('#objectives').find('.objective').first().clone(true, true);
                    objective.find('textarea').val("");
                    objective.insertBefore($(this));
                    sortObjectives();
                });

                $('.btnDeleteObjective').click(function() {
                    if ($(this).closest('#objectives').children('.objective').length!==1) {
                        $(this).closest('.objective').remove();
                    }
                    sortObjectives();
                });

                function sortObjectives() {
                    let objectiveCtr = 1;
                    $('#objectives').children('.objective').each(function() {
                        $(this).find('.objectiveCtr').html(objectiveCtr++);
                    });
                }

                function provideLetteringNumber(num) {
                    let alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                    if (num > 0 && num <= 26) {
                        return alphabet[num - 1];
                    } else {
                        let dividend = (num);
                        let returnStr = '';
                        let modulo;
                        while (dividend > 0) {
                            modulo = (dividend - 1) % 26;
                            returnStr = alphabet[modulo] + returnStr;
                            dividend = Math.floor(((dividend - modulo) / 26));
                        }
                        return returnStr;
                    }
                }

                // Scope of Work
                $('#btnAddNewScopeOfWork').click(function () {
                    let scopeOfWork = $(this).closest('.scopeOfWorks').find('.scopeOfWork').first().clone(true, true);
                    scopeOfWork.find('.scopeOfWorkName').find('input[type=text]').val("");
                    scopeOfWork.find('.tasks').find('.task:not(:first-child)').remove();
                    scopeOfWork.find('.tasks').find('.task').find('input').val("");
                    scopeOfWork.insertBefore($(this));
                    organizeScopeAndTask();
                });

                $('.btnAddNewTask').click(function() {
                    let task = $(this).closest('.tasks').find('.task').first().clone(true, true);
                    task.find('input').val("");
                    task.insertBefore($(this));
                    organizeScopeAndTask();
                });

                $('.btnDeleteTask').click(function() {
                    if ($(this).closest('.tasks').children('.task').length!=1) {
                        $(this).closest('.task').remove();
                        organizeScopeAndTask();
                    }
                });

                $('.btnDeleteScope').click(function() {
                    if ($(this).closest('.scopeOfWorks').children('.scopeOfWork').length!=1) {
                        $(this).closest('.scopeOfWork').remove();
                        organizeScopeAndTask();
                    }
                });

                // Project Name Update
                $('#projectName').change(function () {
                    if ($(this).val() != "") {
                        $.post("/ajax/esd-generic-proposal-get-values", {
                            id: $(this).val()
                        }, function (data) {
                            if (data.status == "ok") {
                                $('#addressLine1').val(data.addressLine1);
                                $('#addressLine1').change();
                                $('#clientName').val(data.clientName);
                                $('#clientName').change();
                            }
                        });
                    } else {
                        $('#addressLine1').val("");
                        $('#addressLine1').change();
                        $('#clientName').val("");
                        $('#clientName').change();
                    }
                });

                // Power Quality Item

                function sortPQA() {
                    let itemCtr = 0;
                    $('#powerQualityItems').find('.powerQualityItem').each(function() {
                       $(this).find('.pqaItemCtr').html(itemCtr+1);
                       $(this).find('.powerQualityItemName').attr('name','pqa['+itemCtr+'][name]');
                       let subitemCtr = 0;
                       $(this).find('.powerQualitySubItems').find('.powerQualitySubItem').each(function() {
                            $(this).find('.pqaSICtr').html((itemCtr+1)+'.'+(subitemCtr+1));
                            $(this).find('input').attr('name','pqa['+itemCtr+'][subItem]['+subitemCtr+']');
                            subitemCtr+=1;
                       });
                       itemCtr+=1;
                    });
                }

                $('#btnAddNewPQAItem').on('click', function() {
                    let pqaItem = $('#powerQualityItems').find('.powerQualityItem').first().clone(true, true);
                    pqaItem.find('.powerQualityItemName').val();
                    pqaItem.find('.powerQualityItemName').val();
                    pqaItem.find('.powerQualitySubItems').find('.powerQualitySubItem').not(':first-child').remove();
                    pqaItem.insertBefore($(this));
                    sortPQA();
                });

                $('.btnAddNewPQASubItem').on('click', function() {
                    let pqaSubItem = $(this).closest('.powerQualitySubItems').find('.powerQualitySubItem').first().clone(true, true);
                    pqaSubItem.find('input').val('');
                    pqaSubItem.insertBefore($(this));
                    sortPQA();
                });

                $('.btnDeletePQAItem').on('click', function() {
                    if ($(this).closest('#powerQualityItems').find('.powerQualityItem').length!=1) {
                        $(this).closest('.powerQualityItem').remove();
                        sortPQA();
                    }
                })

                $('.btnDeletePQASubItem').on('click', function() {
                   if ($(this).closest('.powerQualitySubItems').find('.powerQualitySubItem').length!=1) {
                       $(this).closest('.powerQualitySubItem').remove();
                       sortPQA();
                   }
                });

                // Sidebar Values

                $('#clientName').on("keyup", function () {
                    if ($('#clientName').val() == "") {
                        $('#clientNamePreview').html("[Company/Client Name]");
                    } else {
                        $('#clientNamePreview').html($('#clientName').val());
                    }
                }).on("change", function () {
                    if ($('#clientName').val() == "") {
                        $('#clientNamePreview').html("[Company/Client Name]");
                    } else {
                        $('#clientNamePreview').html($('#clientName').val());
                    }
                }).on("focus", function () {
                    $('#clientNamePreview').addClass('bg-gray-dark');
                    $('#clientNamePreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('#clientNamePreview').addClass('bg-gray-light');
                    $('#clientNamePreview').removeClass('bg-gray-dark');
                });

                $('#addressLine1').on("keyup", function () {
                    if ($('#addressLine1').val() == "") {
                        $('#addressLine1Preview').html("[Address Line 1]");
                    } else {
                        $('#addressLine1Preview').html($('#addressLine1').val());
                    }
                }).on("change", function () {
                    if ($('#addressLine1').val() == "") {
                        $('#addressLine1Preview').html("[Address Line 1]");
                    } else {
                        $('#addressLine1Preview').html($('#addressLine1').val());
                    }
                }).on("focus", function () {
                    $('#addressLine1Preview').addClass('bg-gray-dark');
                    $('#addressLine1Preview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('#addressLine1Preview').addClass('bg-gray-light');
                    $('#addressLine1Preview').removeClass('bg-gray-dark');
                });

                $('#addressLine2').on("keyup", function () {
                    if ($('#addressLine2').val() == "") {
                        $('#addressLine2Preview').html("[Address Line 2]");
                    } else {
                        $('#addressLine2Preview').html($('#addressLine2').val());
                    }
                }).on("change", function () {
                    if ($('#addressLine2').val() == "") {
                        $('#addressLine2Preview').html("[Address Line 2]");
                    } else {
                        $('#addressLine2Preview').html($('#addressLine2').val());
                    }
                }).on("focus", function () {
                    $('#addressLine2Preview').addClass('bg-gray-dark');
                    $('#addressLine2Preview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('#addressLine2Preview').addClass('bg-gray-light');
                    $('#addressLine2Preview').removeClass('bg-gray-dark');
                });

                $('#paymentTerms').on("keyup", function () {
                    if ($('#paymentTerms').val() == "") {
                        $('#paymentTermsPreview').html("[Payment Terms]");
                    } else {
                        $('#paymentTermsPreview').html($('#paymentTerms').val());
                    }
                }).on("change", function () {
                    if ($('#paymentTerms').val() == "") {
                        $('#paymentTermsPreview').html("[Payment Terms]");
                    } else {
                        $('#paymentTermsPreview').html($('#paymentTerms').val());
                    }
                }).on("focus", function () {
                    $('#paymentTermsPreview').addClass('bg-gray-dark');
                    $('#paymentTermsPreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('#paymentTermsPreview').addClass('bg-gray-light');
                    $('#paymentTermsPreview').removeClass('bg-gray-dark');
                });

                $('#proposalValidity').on("keyup", function () {
                    if ($('#proposalValidity').val() == "") {
                        $('#proposalValidityPreview').html("[Proposal Validity]");
                    } else {
                        $('#proposalValidityPreview').html($('#proposalValidity').val());
                    }
                }).on("change", function () {
                    if ($('#proposalValidity').val() == "") {
                        $('#proposalValidityPreview').html("[Proposal Validity]");
                    } else {
                        $('#proposalValidityPreview').html($('#proposalValidity').val());
                    }
                }).on("focus", function () {
                    $('#proposalValidityPreview').addClass('bg-gray-dark');
                    $('#proposalValidityPreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('#proposalValidityPreview').addClass('bg-gray-light');
                    $('#proposalValidityPreview').removeClass('bg-gray-dark');
                });

                $('#conformeSignatoryName').on("keyup", function () {
                    if ($('#conformeSignatoryName').val() == "") {
                        $('#conformeSignatoryNamePreview').html("[Conforme Signatory Name]");
                    } else {
                        $('#conformeSignatoryNamePreview').html($('#conformeSignatoryName').val());
                    }
                }).on("change", function () {
                    if ($('#conformeSignatoryName').val() == "") {
                        $('#conformeSignatoryNamePreview').html("[Conforme Signatory Name]");
                    } else {
                        $('#conformeSignatoryNamePreview').html($('#conformeSignatoryName').val());
                    }
                }).on("focus", function () {
                    $('#conformeSignatoryNamePreview').addClass('bg-gray-dark');
                    $('#conformeSignatoryNamePreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('#conformeSignatoryNamePreview').addClass('bg-gray-light');
                    $('#conformeSignatoryNamePreview').removeClass('bg-gray-dark');
                });

                $('#conformeSignatoryContact').on("keyup", function () {
                    if ($('#conformeSignatoryContact').val() == "") {
                        $('#conformeSignatoryContactPreview').html("[Conforme Signatory Contact]");
                    } else {
                        $('#conformeSignatoryContactPreview').html($('#conformeSignatoryContact').val());
                    }
                }).on("change", function () {
                    if ($('#conformeSignatoryContact').val() == "") {
                        $('#conformeSignatoryContactPreview').html("[Conforme Signatory Contact]");
                    } else {
                        $('#conformeSignatoryContactPreview').html($('#conformeSignatoryContact').val());
                    }
                }).on("focus", function () {
                    $('#conformeSignatoryContactPreview').addClass('bg-gray-dark');
                    $('#conformeSignatoryContactPreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('#conformeSignatoryContactPreview').addClass('bg-gray-light');
                    $('#conformeSignatoryContactPreview').removeClass('bg-gray-dark');
                });

                $('#signatoryName').on("keyup", function () {
                    if ($('#signatoryName').val() == "") {
                        $('.signatoryNamePreview').html("[Signatory Name]");
                    } else {
                        $('.signatoryNamePreview').html($('#signatoryName').val());
                    }
                }).on("change", function () {
                    if ($('#signatoryName').val() == "") {
                        $('.signatoryNamePreview').html("[Signatory Name]");
                    } else {
                        $('.signatoryNamePreview').html($('#signatoryName').val());
                    }
                }).on("focus", function () {
                    $('.signatoryNamePreview').addClass('bg-gray-dark');
                    $('.signatoryNamePreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('.signatoryNamePreview').addClass('bg-gray-light');
                    $('.signatoryNamePreview').removeClass('bg-gray-dark');
                });

                $('#signatoryPosition').on("keyup", function () {
                    if ($('#signatoryPosition').val() == "") {
                        $('.signatoryPositionPreview').html("[Signatory Position]");
                    } else {
                        $('.signatoryPositionPreview').html($('#signatoryPosition').val());
                    }
                }).on("change", function () {
                    if ($('#signatoryPosition').val() == "") {
                        $('.signatoryPositionPreview').html("[Signatory Position]");
                    } else {
                        $('.signatoryPositionPreview').html($('#signatoryPosition').val());
                    }
                }).on("focus", function () {
                    $('.signatoryPositionPreview').addClass('bg-gray-dark');
                    $('.signatoryPositionPreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('.signatoryPositionPreview').addClass('bg-gray-light');
                    $('.signatoryPositionPreview').removeClass('bg-gray-dark');
                });

                $('#signatoryDepartment').on("keyup", function () {
                    if ($('#signatoryDepartment').val() == "") {
                        $('.signatoryDepartmentPreview').html("[Signatory Department]");
                    } else {
                        $('.signatoryDepartmentPreview').html($('#signatoryDepartment').val());
                    }
                }).on("change", function () {
                    if ($('#signatoryDepartment').val() == "") {
                        $('.signatoryDepartmentPreview').html("[Signatory Department]");
                    } else {
                        $('.signatoryDepartmentPreview').html($('#signatoryDepartment').val());
                    }
                }).on("focus", function () {
                    $('.signatoryDepartmentPreview').addClass('bg-gray-dark');
                    $('.signatoryDepartmentPreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('.signatoryDepartmentPreview').addClass('bg-gray-light');
                    $('.signatoryDepartmentPreview').removeClass('bg-gray-dark');
                });

                $('#letterSubject').on("keyup", function () {
                    if ($('#letterSubject').val() == "") {
                        $('#letterSubjectPreview').html("[Letter Subject]");
                    } else {
                        $('#letterSubjectPreview').html($('#letterSubject').val());
                    }
                }).on("change", function () {
                    if ($('#letterSubject').val() == "") {
                        $('#letterSubjectPreview').html("[Letter Subject]");
                    } else {
                        $('#letterSubjectPreview').html($('#letterSubject').val());
                    }
                }).on("focus", function () {
                    $('#letterSubjectPreview').addClass('bg-gray-dark');
                    $('#letterSubjectPreview').removeClass('bg-gray-light');
                }).on("blur", function () {
                    $('#letterSubjectPreview').addClass('bg-gray-light');
                    $('#letterSubjectPreview').removeClass('bg-gray-dark');
                });


                // change save status
                $('#save-status').on('change', function(){

                    if($(this).is(':checked')) {
                        $(this).val('1');
                        $(this).closest('div').find('label').html('<?php echo renderLang($lang_for_submission); ?>');
                        $('#save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_for_submission); ?>');

                    } else {
                        $(this).val('0');
                        $(this).closest('div').find('label').html('<?php echo renderLang($lang_save_as_draft); ?>');
                        $('#save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_save_as_draft); ?>');
                    }

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