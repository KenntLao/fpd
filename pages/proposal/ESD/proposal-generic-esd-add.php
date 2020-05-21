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
        $sql = $pdo->prepare("SELECT * FROM proposal_esd_generic UNION SELECT id, reference_number FROM proposal_esd_etspqa UNION SELECT id, reference_number FROM proposal_esd_tsa ORDER BY id DESC LIMIT 1");
        $sql->execute();
        if($sql->rowCount()) {
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
            $reference_number = explode('-', $_data['reference_number']);
            $reference_id = (int)$reference_number[2] + 1;
            $suggested_reference_number = $reference_number[0].'-'.$date_code.'-'.$reference_id;
        } else {
            $suggested_reference_number = 'ESD-'.$date_code.'-100001';
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
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($generic_proposal_esd_add); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <form method="post" action="/submit-add-esd-generic-proposal">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($generic_proposal_esd); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">
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
                                                    echo '<option value="'.$data['id'].'">'.$data['project_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label>Reference Number</label>
                                        <input type="text" class="form-control" id="referenceNo" name="reference_number" value="<?php echo $suggested_reference_number; ?>" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Date</label>
                                        <input type="text" class="form-control date" id="longDate" name="date"/>
                                    </div>
                                    <div class="col-12">
                                        <br />
                                    </div>
                                    <div class="col-12">
                                        <ul class="nav nav-tabs" id="proposalContentsTabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="letter-tab" data-toggle="tab" href="#letter" role="tab" aria-controls="letter" aria-selected="true">Letter</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="itemsAndCostings-tab" data-toggle="tab" href="#itemsAndCostings" role="tab" aria-controls="itemsAndCostings" aria-selected="false">Items and Costings</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="proposalContentsWindows">
                                            <div class="tab-pane fade show active" id="letter" role="tabpanel" aria-labelledby="letter-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">
                                                        <label>Salutation</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-prepend input-group-text">
                                                                    Dear
                                                                </div>
                                                                <select class="form-control" id="salutationIntro" name="salutation">
                                                                    <?php 
                                                                    foreach($salutation_arr as $key => $salutation) {
                                                                        echo '<option value="'.$salutation[0].'">'.renderLang($salutation).'</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <input type="text" class="form-control" id="salutation" name="client"/>
                                                        </div>
                                                        <br />
                                                        <label>Service Type</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <select class="form-control" id="serviceType" name="service_name">
                                                                    <option value=""></option>
                                                                    <?php 
                                                                    foreach($esd_proposal_service_type_arr as $service_key => $service_types) {
                                                                        echo '<option value="'.$service_key.'">'.renderLang($service_types).'</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <input type="text" class="form-control" disabled id="serviceTypeOther" name="other_service" placeholder="Please state"/>
                                                        </div>
                                                        <br />
                                                        <label>Works</label>
                                                        <input type="text" class="form-control mb-1" id="works" name="works" placeholder="Works"/>
                                                        <br />
                                                        <label>Company/Client Name</label>
                                                        <input type="text" class="form-control mb-1" id="clientName" name="company" placeholder="Client Name"/>
                                                        <br />
                                                        <label>Address</label>
                                                        <input type="text" class="form-control mb-1" id="addressLine1" name="address_line1" placeholder="Line 1"/>
                                                        <input type="text" class="form-control mb-1" id="addressLine2" name="address_line2" placeholder="Line 2"/>
                                                        <br />
                                                        <label>Short Location</label>
                                                        <textarea class="form-control" placeholder="Short Location" id="shortLocation" name="short_location"></textarea>
                                                        <br />
                                                        <!-- <label>Specialization</label>
                                                        <textarea class="form-control" placeholder="Specialization" id="specialization" name="specialization"></textarea>
                                                        <br /> -->
                                                        <label>Payment Terms</label>
                                                        <textarea class="form-control" placeholder="Payment Terms" id="paymentTerms" name="payment_terms"></textarea>
                                                        <br />
                                                        <label>Proposal Validity</label>
                                                        <textarea class="form-control" placeholder="Proposal Validity" id="proposalValidity" name="validity_period"></textarea>
                                                        <br />
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="warrantyDisplay">
                                                            <label class="form-check-label" for="warrantyDisplay">
                                                                <b>Warranty Period</b>
                                                            </label>
                                                        </div>
                                                        <select class="form-control" id="warrantyPeriod" name="waranty_period" disabled>
                                                            <option value="30 days on worksmanship only">30 days on worksmanship only</option>
                                                            <option value="30 days on parts and worksmanship">30 days on parts and worksmanship</option>
                                                            <option value="30 days on parts only">30 days on parts only</option>
                                                            <option value="30 days on labor only">30 days on labor only</option>
                                                            <option value="30 days on parts and labor">30 days on parts and labor</option>
                                                            <option value="30 days on parts and supervision">30 days on parts and supervision</option>
                                                            <option value="1 year on parts and 3 months on worksmanship">1 year on parts and 3 months on worksmanship</option>
                                                            <option value="1 year against manufacturer defect and 3 months on workmanship only">1 year against manufacturer defect and 3 months on workmanship only</option>
                                                        </select>
                                                        <textarea class="form-control" id="customWarrantyExplanation" name="customWarrantyExplanation" placeholder="Custom Warranty Explanation" disabled></textarea>
                                                        <!-- <textarea disabled class="form-control" placeholder="Warranty Period" "></textarea> -->
                                                        <br />
                                                        <label>Signatory</label>
                                                        <?php 
                                                            $department = '';
                                                            if ($_SESSION['sys_account_mode'] == "employee") {
                                                                $department = getField('department_name', 'departments JOIN employees ON(departments.id = employees.department_id)', 'employees.id = '.$_SESSION['sys_id']);
                                                            }
                                                        ?>
                                                        <input type="text" class="form-control mb-1" id="signatoryName" name="signatoryName" placeholder="Name" value="<?php echo getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']); ?>"/>
                                                        <input type="text" class="form-control mb-1" id="signatoryPosition" name="signatoryPosition" placeholder="Position"/>
                                                        <input type="text" class="form-control mb-1" id="signatoryDepartment" name="signatoryDepartment" placeholder="Department" value="<?= $department ?>" />
                                                        <br />
                                                        <label>Conforme</label>
                                                        <input type="text" class="form-control mb-1" id="conformeSignatoryName" placeholder="Name" name="conforme"/>
                                                        <input type="text" class="form-control mb-1" id="conformeSignatoryContact" placeholder="Contact" name="conforme_contact"/>
                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-10">
                                                                            Ref. No. <span class="bg-gray-light pl-2 pr-2 referenceNoPreview" data-toggle="tooltip" data-placement="top" title="Reference Number"><?php echo $suggested_reference_number; ?></span>
                                                                            <br /><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 longDatePreview" data-toggle="tooltip" data-placement="top" title="Long Date">[Long Date]</span>
                                                                            <br /><br /><br />
                                                                            <span class="bg-gray-light pl-2 pr-2" id="clientNamePreview" data-toggle="tooltip" data-placement="top" title="Company/Client Name">[Company/Client Name]</span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2" id="addressLine1Preview" data-toggle="tooltip" data-placement="top" title="Address Line 1">[Address Line 1]</span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2" id="addressLine2Preview" data-toggle="tooltip" data-placement="top" title="Address Line 2">[Address Line 2]</span><br /><br /><br />
                                                                        </div>
                                                                        <div class="col-2 text-right">
                                                                            <img src="/assets/images/Company%20Logo.png" style="width: 100%"/>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <p class="text-justify">Dear <span class="bg-gray-light pl-2 pr-2 salutationPreview" data-toggle="tooltip" data-placement="top" title="Salutation">[Salutation]</span></p>
                                                                            <p class="text-justify">FPD Asia Property Services, Inc., would like to offer our <span class="bg-gray-light pl-2 pr-2" id="serviceTypePreview"  data-toggle="tooltip" data-placement="top" title="Service Type">[Service Type]</span> for <span class="bg-gray-light pl-2 pr-2" id="worksPreview" data-toggle="tooltip" data-placement="top" title="Works">[Works]</span> located at <span class="bg-gray-light pl-2 pr-2" id="shortLocationPreview" data-toggle="tooltip" data-placement="top" title="Short Location">[Short Location]</span>.  We specialize in the management of commercial and office buildings, residential condominiums, engineering facilities, manufacturing plants, retail developments (malls), resorts, villages and subdivisions. We also offer engineering and technical services to fit all your
                                                                                properties needs and requirements.</p>
                                                                            <p class="text-justify">Based on our site inspection, FPD Asia will provide a professional maintenance team, tools, materials and equipment necessary to the completion of the proposed services within 7-10 working days after receipt of approved purchase order. </p>
                                                                            <p class="text-justify">Our offered terms of payment is <span class="bg-gray-light pl-2 pr-2" id="paymentTermsPreview" data-toggle="tooltip" data-placement="top" title="Payment Terms">[Payment Terms]</span>.  The proposal shall be valid for <span class="bg-gray-light pl-2 pr-2" id="proposalValidityPreview" data-toggle="tooltip" data-placement="top" title="Proposal Validity">[Proposal Validity]</span>.
                                                                                <span id="warrantyDisplayPreview">FPD Asia will provide warranty of
                                                                                    <span class="bg-gray-light pl-2 pr-2" id="warrantyPeriodPreview" data-toggle="tooltip" data-placement="top" title="Warranty Period">[Warranty Period]</span>.
                                                                                    <span class="bg-gray-light pl-2 pr-2" id="customWarrantyExplanationPreview" data-toggle="tooltip" data-placement="top" title="Custom Warranty Explanation">[Custom Warranty Explanation]</span>
                                                                                </span></p>
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
                                                                        <div class="col-6">
                                                                            <p>CONFORME</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p>
                                                                                <span class="bg-gray-light pl-2 pr-2" id="conformeSignatoryNamePreview" data-toggle="tooltip" data-placement="top" title="Conforme Signatory Name">[Conforme Signatory Name]</span><br />
                                                                                Contact: <span class="bg-gray-light pl-2 pr-2" id="conformeSignatoryContactPreview" data-toggle="tooltip" data-placement="top" title="Conforme Signatory Contact">[Conforme Signatory Contact]</span>
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="itemsAndCostings" role="tabpanel" aria-labelledby="itemsAndCostings-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">
                                                        <label>Letter Subject</label>
                                                        <input type="text" class="form-control mb-1" id="letterSubject" name="letter_subject" placeholder="Letter Subject"/>
                                                        <br />
                                                        <span class="text-gray" style="font-size: 14pt">You may edit the items and costings on the right side respectively.</span>
                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>ITEMS AND COSTINGS PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-10">
                                                                            <span class="bg-gray-light pl-2 pr-2 longDatePreview" data-toggle="tooltip" data-placement="top" title="Long Date">[Long Date]</span><br /><br />
                                                                            Ref. No. <span class="bg-gray-light pl-2 pr-2 referenceNoPreview"  data-toggle="tooltip" data-placement="top" title="Reference Number"><?php echo $suggested_reference_number; ?></span>
                                                                            <br /><br />
                                                                            Subject: <span class="bg-gray-light pl-2 pr-2" id="letterSubjectPreview" data-toggle="tooltip" data-placement="top" title="Letter Subject">[Letter Subject]</span>
                                                                            <br /><br /><br />
                                                                        </div>
                                                                        <div class="col-2 text-right">
                                                                            <img src="/assets/images/Company%20Logo.png" style="width: 100%"/>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <p class="text-justify">Dear <span class="bg-gray-light pl-2 pr-2 salutationPreview" data-toggle="tooltip" data-placement="top" title="Salutation">[Salutation]</span></p>
                                                                            <p class="text-justify">Please find herewith our proposal as follows:</p>
                                                                        </div>
                                                                        <div class="col-12 mb-5">
                                                                            <div id="items">
                                                                                <div class="item pt-3 pb-3" style="border-top: 1px solid lightgrey; border-bottom: 1px solid lightgrey">
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text itemCtr">Item 1</span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control itemName" placeholder="Item Name" name="item_name[]"/>
                                                                                        <input type="hidden" name="item_code[]" value="1" class="item-code">
                                                                                        <div class="input-group-append">
                                                                                            <button class="btn bg-gray-light btnDeleteItem" type="button"><i class="fa fa-trash-alt text-gray"></i></button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <span style="font-size: 12pt">Scope of Works: </span>
                                                                                    <div class="scopeOfWorks">
                                                                                        <div class="input-group scopeOfWork mb-3">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text"><b>·</b></span>
                                                                                            </div>
                                                                                            <textarea type="text" class="form-control" placeholder="Scope of Work" name="material_name[]"></textarea>
                                                                                            <input type="hidden" name="material_code[]" value="1" class="material-code">
                                                                                            <div class="input-group-append">
                                                                                                <button class="btn bg-gray-light btnDelete" type="button"><i class="fa fa-trash-alt text-gray"></i></button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <button class="btn btn-block bg-gray-light text-gray btnAddNewScopeOfWork" type="button">Add New Scope of Work</button>
                                                                                    </div>
                                                                                    <span style="font-size: 12pt">
                                                                                        <input type="checkbox" class="costingsEnable">
                                                                                        <input type="hidden" name="hasCosting[]" value="0">
                                                                                        Costings: </span>
                                                                                    <div class="costings" style="display: none">
                                                                                        <table class="table table-bordered costing" style="font-size: 10pt">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th class="align-middle" colspan="11">
                                                                                                    Costing 1
                                                                                                    </th>
                                                                                                    <input type="hidden" name="labor_cost_code[]" value="1" class="labor-cost-code">
                                                                                                    <input type="hidden" name="option_code[]" value="11" class="option-code">
                                                                                                    <th class="align-middle text-center bg-gray-light btnDelete" style="cursor: pointer">
                                                                                                        <i class="fa fa-trash-alt"></i>
                                                                                                    </th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="align-middle text-center" rowspan="2">#</th>
                                                                                                    <th class="align-middle text-center" rowspan="2">Description</th>
                                                                                                    <th class="align-middle text-center" colspan="4">Materials</th>
                                                                                                    <th class="align-middle text-center" colspan="4">Labor Cost</th>
                                                                                                    <th class="align-middle text-center" rowspan="2">Sub Total</th>
                                                                                                    <th class="align-middle text-center" rowspan="2"></th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="align-middle text-center" style="width: 7%">Qty</th>
                                                                                                    <th class="align-middle text-center" style="width: 10%">Unit</th>
                                                                                                    <th class="align-middle text-center" style="width: 10%">Unit Cost</th>
                                                                                                    <th class="align-middle text-center" style="width: 10%">Amount</th>
                                                                                                    <th class="align-middle text-center" style="width: 7%">Qty</th>
                                                                                                    <th class="align-middle text-center" style="width: 10%">Unit</th>
                                                                                                    <th class="align-middle text-center" style="width: 10%">Unit Cost</th>
                                                                                                    <th class="align-middle text-center" style="width: 10%">Amount</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody class="computationRows">
                                                                                                <tr class="computationRow">
                                                                                                    <input type="hidden" name="options_code[]" value="11" class="options-code">
                                                                                                    <td class="align-middle text-center">1</td>
                                                                                                    <td class="align-middle text-left">
                                                                                                        <textarea class="form-control border-0 rowDescription" placeholder="Description" name="description[]"></textarea>
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right">
                                                                                                        <input type="number" class="form-control border-0 rowMaterialQty" placeholder="#" name="quantity[]">
                                                                                                    </td>
                                                                                                    <td class="align-middle text-left">
                                                                                                        <input type="text" class="form-control border-0 rowMaterialUnit" placeholder="Unit" name="unit[]">
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right">
                                                                                                        <input type="number" class="form-control border-0 rowMaterialUnitCost" placeholder="Unit Cost" name="unit_price[]">
                                                                                                        <input type="hidden" name="total_price[]" class="totalPrice">
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right rowMaterialAmt">
                                                                                                        0.00
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right">
                                                                                                        <input type="number" class="form-control border-0 rowLaborQty" placeholder="#" name="lc_quantity[]">
                                                                                                    </td>
                                                                                                    <td class="align-middle text-left">
                                                                                                        <input type="text" class="form-control border-0 rowLaborUnit" placeholder="Unit" name="lc_unit[]">
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right">
                                                                                                        <input type="number"  class="form-control border-0 rowLaborUnitCost" placeholder="Unit Cost" name="lc_unit_cost[]">
                                                                                                        <input type="hidden" name="lc_total_amount[]" class="lcTotalAmount">
                                                                                                        <input type="hidden" name="sub_total[]" class="subTotal">
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right rowLaborAmt">
                                                                                                        0.00
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right rowSubTotal">
                                                                                                        0.00
                                                                                                    </td>
                                                                                                    <td class="align-middle text-center">
                                                                                                        <button type="button" class="btn bg-gray-light btnDelete"><i class="text-gray fa fa-trash-alt"></i></button>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="12">
                                                                                                        <button class="btn bg-gray-light btn-block btnAddNewComputationRow" type="button">Add New Row</button>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="10">
                                                                                                        Cost
                                                                                                        <input type="hidden" name="labor_cost[]" class="laborCost">
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right computationCost">0.00</td>
                                                                                                    <td class="align-middle text-right"></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="10">
                                                                                                        Value Added Tax (VAT 12%)
                                                                                                        <input type="hidden" name="vat[]" class="vat">
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right computationVAT">0.00</td>
                                                                                                    <td class="align-middle text-right"></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="10" class="align-middle text-left">Others (Free Form)</td>
                                                                                                    <td class="align-middle text-right">
                                                                                                        <input type="text" class="form-control text-right pr-0 border-0 computationOther" style="position: relative; right: -1px;" value="0.00" name="lc_other[]"/>
                                                                                                    </td>
                                                                                                    <td class="align-middle text-right"></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="10"><b>Total Project Cost</b></td>
                                                                                                    <td class="align-middle text-right computationProjectCost">0.00</td>
                                                                                                    <td class="align-middle text-right">
                                                                                                    <input type="hidden" name="total[]" class="grandTotal">
                                                                                                    </td>
                                                                                                    
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <button class="btn btn-block bg-gray-light text-gray btnAddNewCosting" type="button">Add New Costing</button>
                                                                                    </div>
                                                                                </div>
                                                                                <button class="mt-5 btn btn-block bg-gray-light text-gray btnAddNewItem" type="button">Add New Item</button>
                                                                            </div>
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
                                                                <br />
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
    <script src="/assets/js/proposal-generic-esd.js"></script>
    <script>
        $(function(){

            // datepicker
            $('.date').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            // change save status 
            $('#save-status').on('change', function(){

                if($(this).is(':checked')) {
                    $(this).val('1');
                    $(this).closest('div').find('label').html('<?php echo renderLang($proposals_esd_for_checking); ?>');
                    $('#save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($proposals_esd_for_checking); ?>');

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