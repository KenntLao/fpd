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
        $sql = $pdo->prepare("SELECT * FROM proposal_esd_generic ORDER BY id DESC LIMIT 1");
        $sql->execute();
        if($sql->rowCount()) {
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
            $reference_number = explode('-', $_data['reference_number']);
            $reference_id = (int)$reference_number[2] + 1;
            $suggested_reference_number = $reference_number[0].'-'.$date_code.'-'.$reference_id;
        } else {
            $suggested_reference_number = 'BDMD-'.$date_code.'-100001';
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
                                                <a class="nav-link active" id="letter-tab" data-toggle="tab" href="#frontPage" role="tab" aria-controls="frontPage" aria-selected="true">Front Page</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="itemsAndCostings-tab" data-toggle="tab" href="#letterAndIntroduction" role="tab" aria-controls="letterAndIntroduction" aria-selected="false">Letter and Introduction</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="propertyDescription-tab" data-toggle="tab" href="#propertyDescription" role="tab" aria-controls="propertyDescription" aria-selected="false">Property Description</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="itemA-C-tab" data-toggle="tab" href="#itemA-C" role="tab" aria-controls="itemA-C" aria-selected="false">Item A-C</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="itemD-F-tab" data-toggle="tab" href="#itemD-F" role="tab" aria-controls="itemD-F" aria-selected="false">Item D-F</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="itemG-I-tab" data-toggle="tab" href="#itemG-I" role="tab" aria-controls="itemG-I" aria-selected="false">Item G-I</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="annexA-tab" data-toggle="tab" href="#annexA" role="tab" aria-controls="annexA" aria-selected="false">Annex A</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="annexB-tab" data-toggle="tab" href="#annexB" role="tab" aria-controls="annexB" aria-selected="false">Annex B</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="annexC-tab" data-toggle="tab" href="#annexC" role="tab" aria-controls="annexC" aria-selected="false">Annex C</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="annexD-tab" data-toggle="tab" href="#annexD" role="tab" aria-controls="annexD" aria-selected="false">Annex D</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="lastPages-tab" data-toggle="tab" href="#lastPages" role="tab" aria-controls="lastPages" aria-selected="false">Last Pages</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="proposalContentsWindows">
                                            <div class="tab-pane fade show active" id="frontPage" role="tabpanel" aria-labelledby="frontPage-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">
                                                        <label>Property Name</label>
                                                        <input type="text" class="form-control mb-1" id="propertyName" placeholder="Property Name">
                                                        <br />
                                                        <label>Short Location</label>
                                                        <input type="text" class="form-control mb-1" id="shortLocation" placeholder="Short Location">
                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12 text-center pt-5 mt-5 mb-5">
                                                                            <img src="/assets/images/Company%20Logo.png" style="height: 3in;" />
                                                                        </div>
                                                                        <div class="col-12 text-center">
                                                                        <span style="font-size: 50px;">PROPERTY MANAGEMENT SERVICES</span><br />
                                                                        <span style="font-size: 35px;">PROPOSAL FOR</span><br /><br />
                                                                        </div>
                                                                        <div class="col-12 text-center pt-2 pb-3" style="background-color: dodgerblue">
                                                                            <span class="text-white pl-2 pr-2 propertyNamePreview" data-toggle="tooltip" data-placement="top" title="Property Name" style="font-size: 50px">[Property Name]</span><br />
                                                                            <span class="text-white pl-2 pr-2 shortLocationFrontPagePreview" data-toggle="tooltip" data-placement="top" title="Short Location" style="font-size: 30px">[Short Location]</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show" id="letterAndIntroduction" role="tabpanel" aria-labelledby="letterAndIntroduction-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">
                                                        <label>Client Name</label>
                                                        <input type="text" class="form-control mb-1" id="clientName" placeholder="Client Name">
                                                        <br />
                                                        <label>Position</label>
                                                        <input type="text" class="form-control mb-1" id="position" placeholder="Position">
                                                        <br />
                                                        <label>Company Name</label>
                                                        <input type="text" class="form-control mb-1" id="companyName" placeholder="Company Name">
                                                        <br />
                                                        <label>Address Line 1</label>
                                                        <textarea type="text" class="form-control mb-1" id="addressLine1" placeholder="Address Line 1"></textarea>
                                                        <br />
                                                        <label>Address Line 2</label>
                                                        <textarea type="text" class="form-control mb-1" id="addressLine2" placeholder="Address Line 2"></textarea>
                                                        <br />
                                                        <label>Contact Person</label>
                                                        <input type="text" class="form-control mb-1" id="contactPerson" placeholder="Contact Person">
                                                        <br />
                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <span class="bg-gray-light pl-2 pr-2 longDatePreview" data-toggle="tooltip" data-placement="top" title="Long Date">[Long Date]</span>
                                                                            <br /><br /><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 clientNamePreview" data-toggle="tooltip" data-placement="top" title="Client Name">[Client Name]</span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 positionPreview" data-toggle="tooltip" data-placement="top" title="Position">[Position]</span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 companyNamePreview" data-toggle="tooltip" data-placement="top" title="Company Name">[Company Name]</span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 addressLine1Preview" data-toggle="tooltip" data-placement="top" title="Address Line 1">[Address Line 1]</span><br />
                                                                            <span class="bg-gray-light pl-2 pr-2 addressLine2Preview" data-toggle="tooltip" data-placement="top" title="Address Line 2">[Address Line 2]</span>
                                                                            <br /><br />
                                                                            <div class="col-12 pl-5 ml-5">
                                                                                THRU:
                                                                                <div class="ml-5 d-inline-block">
                                                                                    <span class="bg-gray-light pl-2 pr-2 contactPersonPreview" data-toggle="tooltip" data-placement="top" title="Contact Person">[Contact Person]</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 pl-5 ml-5" >
                                                                                <div class="d-inline-block" style="vertical-align: top">
                                                                                SUBJECT:
                                                                                </div>
                                                                                <div class="ml-4 d-inline-block">
                                                                                    Property Management Proposal For<br />
                                                                                    <span class="bg-gray-light pl-2 pr-2 propertyNamePreview" data-toggle="tooltip" data-placement="top" title="Property Name">[Property Name]</span> - <span class="bg-gray-light pl-2 pr-2 shortLocationPreview" data-toggle="tooltip" data-placement="top" title="Short Location">[Short Location]</span>
                                                                                    <br /><br />
                                                                                </div>
                                                                                <br /><br />
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <p><span class="bg-gray-light pl-2 pr-2 salutationPreview" data-toggle="tooltip" data-placement="top" title="Salutation">[Salutation]</span></p>
                                                                                <p>We are pleased to submit our proposal for Property Management Services for <span class="bg-gray-light pl-2 pr-2 propertyNamePreview" data-toggle="tooltip" data-placement="top" title="Property Name">[Property Name]</span> in <span class="bg-gray-light pl-2 pr-2 shortLocationPreview" data-toggle="tooltip" data-placement="top" title="Short Location">[Short Location]</span>.</p>
                                                                                <p>Kindly go over our proposal and should you need clarification on any item, we will be glad to discuss the details with you at your most convenient time.</p>
                                                                                <p>We look forward to being of service to you.</p>
                                                                                <br /><br />
                                                                                <p>Very truly yours,</p><br /><br />
                                                                                <span class="bg-gray-light pl-2 pr-2 signatoryName" data-toggle="tooltip" data-placement="top" title="Signatory Name">[Signatory Name]</span><br />
                                                                                <span class="bg-gray-light pl-2 pr-2 signatoryPosition" data-toggle="tooltip" data-placement="top" title="Signatory Location">[Signatory Location]</span><br />
                                                                                <span class="bg-gray-light pl-2 pr-2 signatoryDepartment" data-toggle="tooltip" data-placement="top" title="Signatory Department">[Signatory Department]</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <h2 style="font-weight: 900">INTRODUCTION</h2>
                                                                            <br />
                                                                        </div>
                                                                        <div class="col-12 p-0">
                                                                            <img src="/assets/images/Company%20Logo.png" style="height: 2in;" />
                                                                            <br /><br />
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <p>FPD Asia Property Services, Inc. is the pioneer in real estate property management services industry in the Philippines. It was established in 1990 and is currently the leader with over 2.7 million square meters gross floor area (GFA) in its managed portfolio.</p>
                                                                            <p>FPD Asia currently manages over 60 projects consisting of prestigious residential, office/commercial and retail condominium developments, manufacturing and office facilities. It is supported by an over 500-strong manpower complement of high-caliber, competent and experienced personnel committed to delivering quality professional property management services to its clients.</p>
                                                                            <p>To maintain its place in the industry and ensure customer satisfaction, FPD Asia implements Quality and Environmental Management Systems for its property management portfolio in accordance with ISO 9001:2015 and ISO 14001:2015.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show" id="propertyDescription" role="tabpanel" aria-labelledby="propertyDescription-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">

                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <h2 style="font-weight: 900">PROPERTY DESCRIPTION</h2>
                                                                            <br />
                                                                            <table class="table no-border">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="w-50">Project Name:</td>
                                                                                        <td class="w-50"><span class="bg-gray-light pl-2 pr-2 projectNamePreview" data-toggle="tooltip" data-placement="top" title="Project Name">[Project Name]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50">Location:</td>
                                                                                        <td class="w-50"><span class="bg-gray-light pl-2 pr-2 locationPreview" data-toggle="tooltip" data-placement="top" title="Location">[Location]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50">Type of Development:</td>
                                                                                        <td class="w-50"><span class="bg-gray-light pl-2 pr-2 typeOfDevelopmentPreview" data-toggle="tooltip" data-placement="top" title="Type of Development">[Type of Development]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50">Owner / Developer:</td>
                                                                                        <td class="w-50"><span class="bg-gray-light pl-2 pr-2 ownerDeveloperPreview" data-toggle="tooltip" data-placement="top" title="Owner / Developer">[Owner / Developer]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50">Service Requirement:</td>
                                                                                        <td class="w-50"><span class="bg-gray-light pl-2 pr-2 serviceRequirementPreview" data-toggle="tooltip" data-placement="top" title="Service Requirement">[Service Requirement]</span><br /><br /></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table class="table no-border">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td><b>Building Properties</b><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Building Age:</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 buildingAgePreview" data-toggle="tooltip" data-placement="top" title="Building Age">[Bulding Age]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Number of Floors:</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 floorsNumberPreview" data-toggle="tooltip" data-placement="top" title="Number of Floors">[Number of Floors]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Number of Floors (Parking):</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 parkingFloorsNumberPreview" data-toggle="tooltip" data-placement="top" title="Number of Floors (Parking)">[Number of Floors (Parking)]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Association Dues:</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 associationDuesPreview" data-toggle="tooltip" data-placement="top" title="Association Dues">[Association Dues]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Joining Fee:</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 joiningFeePreview" data-toggle="tooltip" data-placement="top" title="Joining Fee">[Joining Fee]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Saleable / Leasable Floor Area:</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 saleableFloorAreaPreview" data-toggle="tooltip" data-placement="top" title="Salesable / Leasable Floor Area">[Salesable / Leasable Floor Area]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Total Parking Area:</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 totalParkingAreaPreview" data-toggle="tooltip" data-placement="top" title="Total Parking Area">[Total Parking Area]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Gross Floor Area (Saleable):</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 grossFloorAreaSaleablePreview" data-toggle="tooltip" data-placement="top" title="Gross Floor Area">[Gross Floor Area]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Amenities (Count):</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 amenitiesCountPreview" data-toggle="tooltip" data-placement="top" title="Amenities (Count)">[Amenities (Count)]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Gross Floor Area (Common):</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 grossFloorAreaCommonPreview" data-toggle="tooltip" data-placement="top" title="Project Name">[Gross Floor Area (Common)]</span><br /><br /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-50 pl-5">Amenities:</td>
                                                                                        <td class="w-50 pl-5"><span class="bg-gray-light pl-2 pr-2 amenitiesPreview" data-toggle="tooltip" data-placement="top" title="Amenities">[Amenities]</span><br /><br /></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12 pl-5 pt-5">
                                                                            List of Equipment and Utilities<br /><br />
                                                                            <div class="row" id="equipmentList">
                                                                                <div class="col-6 equipment pb-3">
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">·</span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control" placeholder="Equipment / Utility Name"/>
                                                                                        <div class="input-group-append">
                                                                                            <button class="btn bg-gray-light deleteEquipment" type="button"><i class="fa fa-trash-alt text-gray"></i></button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12 pt-3">
                                                                                    <button class="btn btn-secondary btn-block" type="button" id="btnEquipmentAdd">Add New Equipment</button>
                                                                                </div>
                                                                            </div>
                                                                            <br /><br />
                                                                            <i>*All details above were provided by the Client. Additional information will be added after the ocular inspection of the FPD Asia team.</i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show" id="itemA-C" role="tabpanel" aria-labelledby="itemA-C-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">

                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <h2><b>A. SCOPE OF PROPOSED SERVICES</b></h2>
                                                                        <p>With 28 years experience in the property management industry, FPD Asia is well-positioned to provide expert advice on property management to owners at any life stage of their property – the planning stage, construction and pre-operational stage, and the operational stage, regardless of age.  FPD Asia offers insight on how to save resources and ensure operational efficiency and safety.  Long-running properties may also consult with FPD Asia on how they can improve their operations, comply with statutory requirements, and lower their overall operational expenses.</p>
                                                                        <p>This proposal covers property management services for <span class="bg-gray-light pl-2 pr-2 propertyNamePreview" data-toggle="tooltip" data-placement="top" title="Property Name">[Property Name]</span> in <span class="bg-gray-light pl-2 pr-2 locationPreview" data-toggle="tooltip" data-placement="top" title="Location">[Location]</span>. FPD Asia will provide systems and procedures for the following aspects:</p>
                                                                        <br /><br />
                                                                        <div class="col-12 pl-5 pr-5">
                                                                            <div class="row" id="proposedServices">
                                                                                <div class="col-12 pb-3 proposedService">
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"><span class="proposedServiceCtr">1.</span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control" placeholder="Proposed Service">
                                                                                        <div class="input-group-append">
                                                                                            <button class="btn bg-gray-light deleteProposedService" type="button"><i class="fa fa-trash-alt text-gray"></i></button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12 pt-3">
                                                                                    <button class="btn btn-secondary btn-block" type="button" id="btnProposedServiceAdd">Add New Proposed Service</button>
                                                                                </div>
                                                                            </div>
                                                                            <br />
                                                                            <span>*Details of the scope of services will be disclosed during the presentation</span>
                                                                        <br /><br />
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <h2><b>B. VALUE ENHANCEMENT AND ENERGY MANAGEMENT</b></h2>
                                                                            <div class="row">
                                                                                <div class="col-12 pl-5 pr-5">
                                                                                    <br />
                                                                                    <div class="row" id="valueEnhancements">
                                                                                        <div class="col-12 valueEnhancement pb-3">
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend">
                                                                                            <span class="input-group-text"><span class="proposedServiceCtr">·</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" placeholder="Value Enhancement">
                                                                                                <div class="input-group-append">
                                                                                                    <button class="btn bg-gray-light deleteValueEnhancement" type="button"><i class="fa fa-trash-alt text-gray"></i></button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-12 pt-3">
                                                                                            <button class="btn btn-secondary btn-block" type="button" id="btnValueEnhancementAdd">Add New Value Enhancement</button>
                                                                                        </div>
                                                                                        <br /><br /><br />
                                                                                        <i>*All the non-conformities found, may it be against the established procedures or service non-conformances, shall be resolved by issuing non-conformity reports.</i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <h2><b>C. HEAD OFFICE SUPPORT</b></h2>
                                                                        <br /><br />
                                                                        <div class="col-12 pl-5 pr-5">
                                                                            <div class="row" id="headOfficeSupportItems">
                                                                                <div class="col-12 pb-3 headOfficeSupportItem">
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">·</span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control" placeholder="Head Office Support Item">
                                                                                        <div class="input-group-append">
                                                                                            <button class="btn bg-gray-light btnDeleteHeadOfficeSupportItem" type="button"><i class="fa fa-trash-alt text-gray"></i></button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12 pt-3">
                                                                                    <button class="btn btn-secondary btn-block" type="button" id="btnHeadOfficeSupportItemAdd">Add New Head Office Support Item</button>
                                                                                </div>
                                                                            </div>
                                                                            <br />
                                                                            <br /><br />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show" id="itemD-F" role="tabpanel" aria-labelledby="itemD-F-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">

                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <h2><b>D. OPTIONAL SERVICES</b></h2><br />
                                                                            <p>FPD Asia provides optional services that are <u>chargeable to the account of the Client.</u></p>
                                                                            <div class="row" id="optionalServices">
                                                                                <div class="col-12 optionalService pl-5 pb-4">
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">·</span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control optionalServiceTitle" placeholder="Title"/>
                                                                                        <div class="input-group-append">
                                                                                            <button class="btn bg-gray-light deleteOptionalService" type="button">
                                                                                                <i class="fa fa-trash-alt"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="input-group pt-2">
                                                                                        <textarea class="form-control optionalServiceDescription" placeholder="Description"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12 pl-5 pt-4">
                                                                                    <button class="btn btn-secondary btn-block" id="btnOptionalServiceAdd" type="button">Add New Optional Service</button>
                                                                                </div>
                                                                            </div>
                                                                            <br /><br />
                                                                            <h2><b>E. CONTRACT DURATION</b></h2><br />
                                                                            <p>This proposal covers a contract period of <span class="bg-gray-light pl-2 pr-2 contractPeriodPreview" data-toggle="tooltip" data-placement="top" title="Contract Period">[Contract Period]</span> from the commencement of the management of <span class="bg-gray-light pl-2 pr-2 propertyNamePreview" data-toggle="tooltip" data-placement="top" title="Property Name">[Property Name]</span> by FPD Asia.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                                </div>
                                                                <div class="col-12 pt-2 pl-3" style="">
                                                                    <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                        <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                            <div class="col-12">
                                                                                <h2><b>F. PROPOSED MANPOWER COMPLEMENT</b></h2><br />
                                                                                <p>This proposal aims to deploy personnel capable of supervising and managing the property management services for <span class="bg-gray-light pl-2 pr-2 propertyNamePreview" data-toggle="tooltip" data-placement="top" title="Property Name">[Property Name]</span>.</p>
                                                                                <table class="table table-bordered">
                                                                                    <thead>
                                                                                        <tr class="bg-gray-light">
                                                                                            <td class="text-center"><b>POSITION</b></td>
                                                                                            <td class="text-center"><b>HC</b></td>
                                                                                            <td class="text-center"><b>JOB DESCRIPTION</b></td>
                                                                                            <td class="text-center"><i class="fa fa-trash-alt"></i></td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="proposedManpowers">
                                                                                        <tr class="proposedManpower">
                                                                                            <td>
                                                                                                <textarea class="form-control manpowerPosition" style="outline: none; border:none"></textarea>
                                                                                            </td>
                                                                                            <td class="align-middle">
                                                                                                <input type="number" class="form-control text-center manpowerHC" style="outline: none; border:none" value="1" min="1"/>
                                                                                            </td>
                                                                                            <td>
                                                                                                <textarea class="form-control manpowerDescription" style="outline: none; border:none"></textarea>
                                                                                            </td>
                                                                                            <td class="align-middle text-center">
                                                                                                <button class="btn btn-sm bg-gray-light btn-block deleteProposedManpower">
                                                                                                    <i class="fa fa-trash-alt"></i>
                                                                                                </button>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="4">
                                                                                                <button class="btn btn-secondary btn-block" id="btnProposedManpowerAdd" type="button">Add New Proposed Manpower</button>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="bg-gray-light pr-5">
                                                                                            <td>TOTAL</td>
                                                                                            <td colspan="3" class="text-right"><span id="totalManpowerHC">0</span>&nbsp;&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <br />
                                                                            </div>
                                                                        </div>
                                                                        <h4><b>Notes on Manpower Complement:</b></h4><br />
                                                                        <div class="row" id="manpowerNotes">
                                                                            <div class="col-12 pl-5 pb-3 manpowerNote">
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text">
                                                                                            ·
                                                                                        </span>
                                                                                    </div>
                                                                                    <textarea type="text" class="form-control"></textarea>
                                                                                    <div class="input-group-append">
                                                                                        <button type="button" class="btn bg-gray-light deleteManpowerNote">
                                                                                            <i class="fa fa-trash-alt"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <button type="button" class="btn btn-secondary btn-block" id="btnManpowerNoteAdd">Add New Manpower Note</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="tab-pane fade show" id="itemG-I" role="tabpanel" aria-labelledby="itemG-I-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">

                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <h2><b>G. PROPOSED ORGANIZATION</b></h2>
                                                                            <div class="col-12 imgProposedOrganization">
                                                                                <span class="bg-gray-light pl-2 pr-2 proposedOrganizationPreview" data-toggle="tooltip" data-placement="top" title="Proposed Organization">[Proposed Organization]</span>
                                                                            </div>
                                                                            <br /><br />
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <h4><b>Notes of Proposed Organization</b></h4>
                                                                            <div class="row" id="proposedOrganizationNotes">
                                                                                <div class="col-12 pl-5 pb-3 proposedOrganizationNote">
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                        <span class="input-group-text">
                                                                                            ·
                                                                                        </span>
                                                                                        </div>
                                                                                        <textarea type="text" class="form-control" placeholder="Proposed Organization Note"></textarea>
                                                                                        <div class="input-group-append">
                                                                                            <button type="button" class="btn bg-gray-light deleteProposedOrganizationNote">
                                                                                                <i class="fa fa-trash-alt"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12 pl-5">
                                                                                    <button type="button" class="btn btn-secondary btn-block" id="btnProposedOrganizationNoteAdd">Add New Proposed Organization Note</button>
                                                                                </div>
                                                                            </div>
                                                                            <br /><br />
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <h2><b>H. DEPLOYMENT SCHEDULE</b></h2>
                                                                            <br />
                                                                            <table class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <td class="align-middle text-center"><b>POSITIONS DEPLOYED</b></td>
                                                                                        <td class="align-middle text-center"><b>TIMELINE</b></td>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table class="table no-border">
                                                                                                <tbody id="personnels">
                                                                                                    <tr class="personnel">
                                                                                                        <td style="width: 30%">
                                                                                                            <input type="number" class="text-right form-control" value="1" min="1"/>
                                                                                                        </td>
                                                                                                        <td style="width: 65%">
                                                                                                            <input type="text" class="form-control text-left" placeholder="Personnel Detail"/>
                                                                                                        </td>
                                                                                                        <td style="width: 5%">
                                                                                                            <button type="button" class="btn bg-gray-light deletePersonnel">
                                                                                                                <i class="fa fa-trash-alt"></i>
                                                                                                            </button>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td colspan="3">
                                                                                                            <button class="btn btn-secondary btn-block" id="btnNewPersonnelsAdd" type="button">Add New Personnel</button>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td class="text-right" style="border-top: 1px solid gray"><b><span id="personnelCtr">1</span>&nbsp;&nbsp;</b></td>
                                                                                                        <td colspan="2" class="text-left" style="border-top: 1px solid gray"><b>&nbsp;&nbsp;Personnel from FPD Asia</b></td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                        <td style="width: 40% !important;">
                                                                                            At least <span class="bg-gray-light pl-2 pr-2 requirementPeriodPreview" data-toggle="tooltip" data-placement="top" title="Requirement Period">[Requirement Period]</span>* from the receipt of the following from the Client:<br /><br />
                                                                                            <div class="row" id="deploymentRequirements">
                                                                                                <div class="col-12 pb-3 deploymentRequirement">
                                                                                                    <div class="input-group">
                                                                                                        <div class="input-group-prepend">
                                                                                                            <span class="input-group-text deploymentRequirementCtr">1</span>
                                                                                                        </div>
                                                                                                        <input class="form-control" type="text" placeholder="Requirement"/>
                                                                                                        <div class="input-group-append">
                                                                                                            <button type="button" class="btn bg-gray-light deleteDeploymentRequirement">
                                                                                                                <i class="fa fa-trash-alt"></i>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-12">
                                                                                                    <button class="btn btn-secondary btn-block" type="button" id="btnDeploymentRequirementAdd">Add Deployment Requirement</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <br />
                                                                            <h4>The <span class="bg-gray-light pl-2 pr-2 requirementPeriodPreview" data-toggle="tooltip" data-placement="top" title="Requirement Period">[Requirement Period]</span> period will only start to run upon receipt of the requirements stated above.  FPD Asia does not undertake to commence the recruitment and selection process until these requirements are complete.</h4>
                                                                            <br /><br />
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <h2><b>I. SCHEDULE OF FEES</b></h2>
                                                                            <h4>The Schedule of Fees includes the monthly <b>Property Administration Charges</b> due to FPD Asia. This does not include administrative and maintenance supplies and other operational expenses of the property. The cost of such shall be for the account of the Client.</h4>
                                                                            <br />
                                                                            <table class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <td>PARTICULARS</td>
                                                                                        <td>MONTHLY FEE</td>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>Property Administrator Charges</td>
                                                                                        <td>
                                                                                            <input class="form-control text-right pr-0" id="propertyAdministratorCharges" type="number" value="0.00" style="border: none"/>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Add 12% VAT</td>
                                                                                        <td class="text-right">₱ <span id="feesVat">0.00</span></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>TOTAL PROPERTY ADMINISTRATOR CHARGES</td>
                                                                                        <td class="text-right">₱ <span id="totalPropertyAdministratorCharges">0.00</span></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <h4><b>Notes on Schedule of Fees:</b></h4><br />
                                                                            <div class="row" id="scheduleOfFeesNotes">
                                                                                <div class="col-12 pb-3 scheduleOfFeesNote">
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">·</span>
                                                                                        </div>
                                                                                        <textarea class="form-control" placeholder="Schedule of Fee Note"></textarea>
                                                                                        <div class="input-group-append">
                                                                                            <button type="button" class="btn bg-gray-light deleteScheduleOfFeeNote">
                                                                                                <i class="fa fa-trash-alt"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <button class="btn btn-block btn-secondary" type="button" id="btnScheduleOfFeeNoteAdd">
                                                                                        Add New Schedule of Fee Note
                                                                                    </button>
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
                                            <div class="tab-pane fade show" id="annexA" role="tabpanel" aria-labelledby="annexA-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">
                                                        * No fillables in this section of the proposal
                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12 text-center">
                                                                            <h2><b>ANNEX A:</b></h2>
                                                                            <h2><b>24/7 ACTION TEAM TERMS & CONDITIONS</b></h2>
                                                                            <br /><br />
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <b>The ACTION TEAM will provide assistance and respond to FPD Asia’s managed buildings during the following situation:</b>
                                                                            <br /><br />
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• In the event of emergencies such as fire, earthquake, flood and other natural calamities;</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• Major common area equipment trouble;</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• Breakdown of any common area equipment which are not under warranty or not maintained by third party service provider;</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• If the trouble is considered emergency and cannot be handled by the in-house technician/s;</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• Equipment trouble or breakdown that may hamper the operation of the building;</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• Incidents that may endanger life and safety of occupants and may damage property; </p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• If the incident involves unit owner’s equipment and/or within the unit owner’s (with the presence of authorized personnel to assist our team inside the unit); </p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• Scheduled Emergency Drill.</p>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <b>Action Team Scope of work:</b>
                                                                            <br /><br />
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• Provide initial repair or remedy to any incident that may cause further damage to property;</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• Provide initial action (e.g. isolating  the source of leak/trouble to temporarily eliminate further damage to property);</p>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <p>After the initial mitigating works are done, recommendation and service report will then be provided to the requesting party. Proposal or referral to specialized contractor will follow subject to approval of the authorized representative. <b>(Refer to ANNEX B: ENGINEERING & TECHNICAL SERVICES RATES)</b></p>
                                                                            <br /><br />
                                                                        </div>
                                                                        <div class="col-12 bg-red text-center">
                                                                            <h2><b>RESTRICTIONS</b></h2>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <br /><br />
                                                                            <b>Action team may refuse to do any works during the following conditions:</b>
                                                                            <br /><br />
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• If the equipment is under the comprehensive warranty by a third party service provider;</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• If in the absence of in-house technician or any authorized personnel to assist our team;</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• If the incident or emergency requires a licensed practitioners supervision;</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>• If the incident or emergency needs authorization from utility service provider.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show" id="annexB" role="tabpanel" aria-labelledby="annexB-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">
                                                        * No fillables in this section of the proposal
                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <div class="col-12 text-center">
                                                                                <h2><b>ANNEX B:</b></h2>
                                                                                <h2><b>ENGINEERING AND TECHNICAL SERVICES</b></h2>
                                                                                <br /><br />
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <p>In line with our commitment to provide high-quality and cost-effective services to our clients, FPD Asia Property Services, Inc. also offers in-unit Engineering and Technical Services to the tenants and unit owners at our Managed Properties.</p>
                                                                            </div>
                                                                            <div class="col-12 pl-3 pt-2 pb-1 bg-blue">
                                                                                <h4><b>A. Aircon Cleaning Services (Preventive Maintenance)</b></h4>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <br />
                                                                                <h4><b>A.1 Long Term Contract Price</b></h4>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <table class="table table-bordered">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <td><b>Equipment</b></td>
                                                                                            <td><b>Capacity</b></td>
                                                                                            <td><b>Volume Rate / Unit</b></td>
                                                                                            <td><b>Retail Rate / Unit</b></td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>Window Type A/C</td>
                                                                                            <td><sup>1</sup>/<sub>2</sub> - 2.5 HP</td>
                                                                                            <td>550.00</td>
                                                                                            <td>750.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Split Type A/C (Wall, Floor or Ceiling Mounted)</td>
                                                                                            <td><sup>3</sup>/<sub>4</sub> - 5 TR</td>
                                                                                            <td>900.00</td>
                                                                                            <td>1100.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Concealed Split Type</td>
                                                                                            <td>2 TR - 5 TR</td>
                                                                                            <td>1150.00</td>
                                                                                            <td>1500.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>AHU/Package Type</td>
                                                                                            <td>10 - 20 TR</td>
                                                                                            <td>1800.00</td>
                                                                                            <td>2500.00</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <br />
                                                                                <h4><b>A.2 One Time Contract Price</b></h4>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <table class="table table-bordered">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <td><b>Equipment</b></td>
                                                                                        <td><b>Capacity</b></td>
                                                                                        <td><b>Volume Rate / Unit</b></td>
                                                                                        <td><b>Retail Rate / Unit</b></td>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>Window Type A/C</td>
                                                                                        <td><sup>1</sup>/<sub>2</sub> - 2.5 HP</td>
                                                                                        <td>650.00</td>
                                                                                        <td>850.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Split Type A/C (Wall, Floor or Ceiling Mounted)</td>
                                                                                        <td><sup>3</sup>/<sub>4</sub> - 5 TR</td>
                                                                                        <td>950.00</td>
                                                                                        <td>1200.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Concealed Split Type</td>
                                                                                        <td>2 TR - 5 TR</td>
                                                                                        <td>1250.00</td>
                                                                                        <td>1500.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>AHU/Package Type</td>
                                                                                        <td>10 - 20 TR</td>
                                                                                        <td>2500.00</td>
                                                                                        <td>2800.00</td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <p>
                                                                                    Note:<br />
                                                                                    Volume: Minimum of three (2) Aircon units<br />
                                                                                    Retail: Less than (3) Aircon units<br />
                                                                                    Frequency of services: Quarterly (4X/yr.)<br />
                                                                                    Minimum Contract Duration: One (1) year<br />
                                                                                    Electricity and water changes if any shall be for the account of the client.<br /><br />
                                                                                    Subscription: Fifty (50) Aircon units and avove in a building = less 5% / un
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <div class="col-12">
                                                                                <br />
                                                                                <h4><b>B. Aircon Repair Works (Minor & Major)</b></h4>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <table class="table table-bordered">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <td><b>Equipment</b></td>
                                                                                        <td><b>Capacity</b></td>
                                                                                        <td><b>Minor Repair Rate / Unit</b></td>
                                                                                        <td><b>Major Repair Rate / Unit</b></td>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>Window Type A/C</td>
                                                                                        <td><sup>1</sup>/<sub>2</sub> - 2.5 HP</td>
                                                                                        <td>1000.00</td>
                                                                                        <td>1800.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Split Type A/C (Wall, Floor or Ceiling Mounted)</td>
                                                                                        <td><sup>3</sup>/<sub>4</sub> - 5 TR</td>
                                                                                        <td>1500.00</td>
                                                                                        <td>2500.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Concealed Split Type</td>
                                                                                        <td>2 TR - 5 TR</td>
                                                                                        <td>1500.00</td>
                                                                                        <td>2500.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>AHU/Package Type</td>
                                                                                        <td>10 - 20 TR</td>
                                                                                        <td>2000.00</td>
                                                                                        <td>5500.00</td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <br />
                                                                                <p>Scope of Minor Repair Works:</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>
                                                                                    1. Replacement of pressure gauges, sight glass and globe valves, etc.<br />
                                                                                    2. Replace magneti contactor, overload relay, controls, starter, etc.<br />
                                                                                    3. Replacement / installation of fan, bearing, motor<br />
                                                                                    4. Leak repair (fittings, capillary tubing, connectors, etc)<br />
                                                                                    5. Charging of refrigerant for undercharge Aircon units<br />
                                                                                    6. Repair of leaks on the drain line, insulation of portion only, painting of corroded portion or support<br />
                                                                                </p>
                                                                                <br />
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <br />
                                                                                <p>Scope of Major Repair Works:</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>
                                                                                    1. Replacement of compressor<br />
                                                                                    2. Replcement, installation, rewinding of blower fan assembly<br />
                                                                                    3. Relocation of unit (subject for assessment)<br />
                                                                                    4. Installation of Aircon units (subject for assessment)<br />
                                                                                </p>
                                                                                <br />
                                                                            </div>
                                                                            <div class="col-12 pl-3 pt-2 pb-1 bg-blue text-center">
                                                                                <h4><b>OTHER SERVICES</b></h4>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <table class="table table-bordered">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <td><b>TYPE OF SERVICE</b></td>
                                                                                            <td><b>SCOPE OF WORK</b></td>
                                                                                            <td><b>HOURLY RATE / TECHNICIAN</b></td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>Electrical Repairs and Installation</td>
                                                                                            <td>Change / repair of switches and outlets<br />
                                                                                                Troubleshooting / repair of shorted electrical circuits<br />
                                                                                                Replacement of defective circuit breakers<br />
                                                                                                Electrical rewiring works<br />
                                                                                                Layout & repair of telephone and intercom units<br />
                                                                                                Installation of additional lights and outlets
                                                                                            </td>
                                                                                            <td>550.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Plumbing Repairs & Installation</td>
                                                                                            <td>Repair of leaking faucets and plumbing fixtures<br />
                                                                                                Replacement of water closet fittings<br />
                                                                                                Replacement of water closets<br />
                                                                                                Declogging of sewer pipes<br />
                                                                                                Replacement of plumbing fixtures<br />
                                                                                                Cleaning of grease traps<br />
                                                                                                Pipe Fittings works (subject for assessment)<br />
                                                                                                Replacement of bathroom tiles (subject for assessment)<br />
                                                                                                Waterproofing works (subject for assessment)<br />
                                                                                                Repair and relocation of fire sprinkler heads
                                                                                            </td>
                                                                                            <td>550.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Civil Works</td>
                                                                                            <td>Welding<br />
                                                                                                Carpentry<br />
                                                                                                Masonry<br />
                                                                                                Painting, etc.<br />
                                                                                            </td>
                                                                                            <td>550.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Pumps and Motors</td>
                                                                                            <td>Repair or replacement
                                                                                            </td>
                                                                                            <td>550.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Grease Trap Cleaning<br />
                                                                                                <br />
                                                                                                Note: Client shall provide proper waste disposal location
                                                                                            </td>
                                                                                            <td>
                                                                                            </td>
                                                                                            <td>550.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Genset Maintenance<br />
                                                                                                <br />
                                                                                                Change oil, air, fuel, filters, etc.
                                                                                            </td>
                                                                                            <td>
                                                                                            </td>
                                                                                            <td>1500.00</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <br />
                                                                                Note:
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                1.	Rate applicable for one (1) technician (MST) only
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                2.	Succeeding labor hourly rate costs P200.00 / MST
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                3.	Travel time to be included on work hours
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                4.	A fraction of an hour is equivalent to one (1) hour
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                5.	A fraction over an hour is considered two (2) hours and so on.
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                6.	Replacement / supply parts and consumables are not included.

                                                                            </div>
                                                                            <div class="col-12">
                                                                                <br /><br />
                                                                                <p>Price is <b>inclusive of VAT</b> and within Metro Manila only. Replacement parts will be quoted separately as needed. Major repairs and renovation shall be inspected before quotation is submitted.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show" id="annexC" role="tabpanel" aria-labelledby="annexC-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">
                                                        * No fillables in this section of the proposal
                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <div class="col-12 text-center">
                                                                                <h2><b>ANNEX C:</b></h2>
                                                                                <h2><b>SPACE & OFFICE EQUIPMENT C/O CLIENT</b></h2>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <p><u>For Admin Office:</u></p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· Minimum of 40 sq. m or 12.5 sq. m. per person;</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· Each employee will have 1 office table and 1 office chair, plus extra chair for guest/visitor per table</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· Each employee to be supplied with 1 set of Computer Desktop. BM to have his own printer and a common printer for the rest of the admin staff. 2 OR printers for the Billing and Collections Assistants.</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· Provide space allocation for reception area -- at least 4-seater conference table.</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· Common Comfort Room within the office or adjacent to the administration area.</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· Admin office should be near the FDAS Panel and CCTV Room.</p>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <br /><br />
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <p><u>For MST Office/Barracks:</u></p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· Minimum of 40 sq. m.</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· With Locker and Dressing Room</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· With Maintenance Tool Cabinets</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· With Stock Room</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· With Workshop and Fabrication Area</p>
                                                                            </div>
                                                                            <div class="col-12 pl-5">
                                                                                <p>· 1 set of Computer Desktop and 1 printer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show" id="annexD" role="tabpanel" aria-labelledby="annexD-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">
                                                        * No fillables in this section of the proposal
                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12 text-center">
                                                                            <h2><b>ANNEX D:</b></h2>
                                                                            <h2><b>OTHER SERVICES</b></h2>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <p>To complement our property management services, FPD Asia also offers the following services. These services are subject to a separate quotation.</p>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <table class="table table-bordered">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>1</td>
                                                                                        <td><b>Project Management Consultancy Services</b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td></td>
                                                                                        <td><p>Technical expertise made available to monitor the construction of a unit in a condominium or building based on the Master Deed with declaration of Restrictions, House Rules, and Construction/Renovation Guidelines.</p></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>2</td>
                                                                                        <td><b>Vetting</b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td></td>
                                                                                        <td><p>We can provide technical expertise to verify the actual implementation of the construction based from the approved construction plan of a house or unit in a building based on the Master Deed with declaration of Restrictions, House Rules, and Construction/Renovation Guidelines.</p></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>3</td>
                                                                                        <td><b>Fit-out Management</b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td></td>
                                                                                        <td><p>Monitors a project based on the terms of reference (TOR), contractor’s compliance, progress of accomplishments and recommends acceptance of the project.</p></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show" id="lastPages" role="tabpanel" aria-labelledby="lastPages-tab">
                                                <div class="row">
                                                    <div class="col-3 pt-3">
                                                        * No fillables in this section of the proposal
                                                    </div>
                                                    <div class="col-9" style="border-left: 1px solid gray">
                                                        <div class="row">
                                                            <div class="col-12 p-3">
                                                                <b>LETTER PREVIEW&nbsp;&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The preview may differ from the actual printed document. However, rest assured that how the items here are arranged are in the same way the generated printed letter is arranged."></i></b>
                                                            </div>
                                                            <div class="col-12 pt-2 pl-3" style="">
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12">
                                                                            <h2><b>WHY FPD Asia?</b></h2>
                                                                            <br />
                                                                            <p>In summary, our proposal for <span class="bg-gray-light pl-2 pr-2 propertyNamePreview" data-toggle="tooltip" data-placement="top" title="Property Name">[Property Name]</span> includes the following features and advantages:</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>· We are the most experienced property management company in the Philippines. FPD Asia started the concept of professional property management in 1990 and it has led the industry since. With over 70 Property Management projects and more than 500 Technical Services contracts, the company is the biggest in the country.</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>· FPD Asia offers world-class management using a documented Quality Management System in accordance with ISO 9001:2015 and Environmental Management System in accordance with ISO 14001:2015. This system ensures uniformity and consistency of practices in Property Management operations in all managed properties of FPD Asia.</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>· Periodic checks of Property Management practices and implementation of corrective and preventive measures to ensure the delivery of quality service in accordance with customer specifications</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5 ml-5">
                                                                            <p>o This is supported by regular visits by a dedicated Operations Managers, as well as top management.</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5 ml-5">
                                                                            <p>o Semi-annual audit by the Internal Quality Audit Group to ensure conformance with our Quality Management System</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5 ml-5">
                                                                            <p>o An annual Technical & Safety Audit of the property conducted by the Engineering Services Division from the Central Office at no extra charge.</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>· Lower long-term operating costs because costly mistakes and errors are eliminated.</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>· Optimal deployment of Property Management personnel supported by a Relief Pool of highly-trained and experienced personnel.</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>· 24-Hour Emergency Response Assistance from the FPD Asia Action Team.</p>
                                                                        </div>
                                                                        <div class="col-12 pl-5">
                                                                            <p>At FPD Asia, property management is not an auxiliary or secondary business for us.  It is our core competence and our main line of business.  This is what we know.  This is what we do.  This is where we excel.  We have the experience, the technical know-how, and the passionate desire to deliver service excellence all the time.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                                <div class="col-12 p-5" style="box-shadow: 0 0 2px gray; min-height: 14in">
                                                                    <div class="row" style="font-family: Calibri; font-size: 14pt">
                                                                        <div class="col-12 text-center">
                                                                            <br /><br /><br /><br /><br /><br /><br /><br />
                                                                            <p>If you have queries about this proposal or<br /><br />
                                                                                simply wish to know more about our Company<br /><br />
                                                                                and the range of services that we are offering,<br /><br />
                                                                                you may call or write us at :<br /><br />
                                                                            </p>
                                                                            <p>
                                                                                <br /><br /><br />
                                                                                FPD Asia Property Services, Inc.<br />
                                                                                <br /><br />
                                                                                The Penthouse, 24H City Hotel<br />
                                                                                1406 Vito Cruz Extension corner<br />
                                                                                Balagtas Street, Makati City 1204<br />
                                                                                Telephone No.:  (632) 815- 3737<br />
                                                                                <br /><br />
                                                                                local 3858, 3868<br />
                                                                                <br /><br />
                                                                                Facsimile No.:  (632) 815 – 2915<br />
                                                                                <br /><br />
                                                                                E-mail: inquiry@fpdasia.net
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
    <script>
        $(function(){
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

            // datepicker
            $('.date').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            // Proposed Equipments

            $('#btnEquipmentAdd').on('click', function() {
                let equipment = $(this).closest('#equipmentList').find('.equipment').first().clone(true, true);
                equipment.find('input').val("");
                equipment.insertBefore($(this).parent());
            });

            $('.deleteEquipment').on('click', function() {
                if ($(this).closest('#equipmentList').children('.equipment').length!=1) {
                    $(this).closest('#equipment').remove();
                }
            });

            // Optional Services

            $('#btnOptionalServiceAdd').on('click', function() {
                let optionalService = $(this).closest('#optionalServices').find('.optionalService').first().clone(true, true);
                optionalService.find('.optionalServiceTitle').val("");
                optionalService.find('.optionalServiceDescription').val("");
                optionalService.insertBefore($(this).parent());
            });

            $('.deleteOptionalService').on('click', function() {
                if ($(this).closest('#optionalServices').children('.optionalService').length!=1) {
                    $(this).closest('.optionalService').remove();
                }
            });

            // Proposed Services

            $('.deleteProposedService').on("click", function() {
                if ($(this).closest('#proposedServices').find('.proposedService').length!=1) {
                    $(this).closest('.proposedService').remove();
                }
                sortProposedServices();
            });

            $('#btnProposedServiceAdd').on('click', function() {
                let proposedService = $(this).closest('#proposedServices').find('.proposedService').first().clone(true, true);
                proposedService.find('input').val("");
                proposedService.insertBefore($(this).parent());
                sortProposedServices();
            });

            function sortProposedServices() {
                let serviceCtr = 1;
                $('#proposedServices').children('.proposedService').each(function() {
                    $(this).find('.proposedServiceCtr').text(serviceCtr++);
                    console.log($(this).find('.proposedServiceCtr'));
                });
            }

            // Value Enhancement

            $('#btnValueEnhancementAdd').on('click', function() {
               let valueEnhancement = $(this).closest('#valueEnhancements').find('.valueEnhancement').first().clone(true, true);
               valueEnhancement.find('input').val("");
               valueEnhancement.insertBefore($(this).parent());
            });

            $('.deleteValueEnhancement').on('click', function() {
                if ($(this).closest('#valueEnhancements').children('.valueEnhancement').length!=1) {
                    $(this).closest('.valueEnhancement').remove();
                }
            });

            // Head Office Support Item

            $('#btnHeadOfficeSupportItemAdd').on('click', function() {
                let HeadOfficeSupportItem = $(this).closest('#headOfficeSupportItems').find('.headOfficeSupportItem').first().clone(true, true);
                HeadOfficeSupportItem.find('input').val("");
                HeadOfficeSupportItem.insertBefore($(this).parent());
            });

            $('.btnDeleteHeadOfficeSupportItem').on('click', function() {
                if ($(this).closest('#headOfficeSupportItems').children('.headOfficeSupportItem').length!=1) {
                    $(this).closest('.headOfficeSupportItem').remove();
                }
            });

            // Proposed Manpower Complement

            $('#btnProposedManpowerAdd').on('click', function() {
                let proposedManpower = $(this).closest('#proposedManpowers').find('.proposedManpower').first().clone(true, true);
                proposedManpower.find('.manpowerPosition').val("");
                proposedManpower.find('.manpowerHC').val(1);
                proposedManpower.find('.manpowerDescription').val("");
                proposedManpower.insertBefore($(this).parent().parent());
                sumTotalManpowerHC()
            });

            $('.manpowerHC').on('keyup', function() {
               sumTotalManpowerHC();
            });

            $('.deleteProposedManpower').on('click', function() {
               if ($('#proposedManpowers').children('.proposedManpower').length!=1) {
                   $(this).closest('.proposedManpower').remove();
               }
               sumTotalManpowerHC();
            });

            function sumTotalManpowerHC() {
                let totalManpowerHCctr = 0;
                $('#proposedManpowers').find('.proposedManpower').each(function() {
                   totalManpowerHCctr += parseInt($(this).find('.manpowerHC').val());
                });
                $('#totalManpowerHC').text(totalManpowerHCctr);
            }

            // Manpower Complement Notes

            $('#btnManpowerNoteAdd').on('click', function() {
                let manpowerNote = $(this).closest('#manpowerNotes').find('.manpowerNote').first().clone(true, true);
                manpowerNote.find('textarea').val("");
                manpowerNote.insertBefore($(this).parent());
            });

            $('.deleteManpowerNote').on('click', function() {
                if ($(this).closest('#manpowerNotes').children('.manpowerNote').length!=1) {
                    $(this).closest('.manpowerNote').remove();
                }
            });

            // Notes of Proposed Organization

            $('#btnProposedOrganizationNoteAdd').on('click', function() {
                let proposedOrganizationNote = $(this).closest('#proposedOrganizationNotes').find('.proposedOrganizationNote').first().clone(true, true);
                proposedOrganizationNote.find('textarea').val("");
                proposedOrganizationNote.insertBefore($(this).parent());
            });

            $('.deleteProposedOrganizationNote').on('click', function() {
                if ($(this).closest('#proposedOrganizationNotes').children('.proposedOrganizationNote').length!=1) {
                    $(this).closest('.proposedOrganizationNote').remove();
                }
            });

            // Personnels and Deployment Requirement

            function sortDeploymentRequirement() {
                let deployementRequirementCtr = 1;
                $('#deploymentRequirements').find('.deploymentRequirement').each(function () {
                    $(this).find('.deploymentRequirementCtr').text(deployementRequirementCtr++);
                });
            }

            $('#btnDeploymentRequirementAdd').on('click', function(){
                let deploymentRequirement = $('#deploymentRequirements').find('.deploymentRequirement').first().clone(true, true);
                deploymentRequirement.find('input').val("");
                deploymentRequirement.insertBefore($(this).parent());
                sortDeploymentRequirement();
            });

            $('.deleteDeploymentRequirement').on('click', function() {
               if ($('#deploymentRequirements').children('.deploymentRequirement').length!=1) {
                   $(this).closest('.deploymentRequirement').remove();
                   sortDeploymentRequirement();
               }
            });

            $('#btnNewPersonnelsAdd').on('click', function() {
                let personnel = $('#personnels').find('.personnel').first().clone(true, true);
                personnel.find('td:nth-child(2) input').val("");
                personnel.find('td:nth-child(1) input').val(1);
                personnel.insertBefore($(this).parent().parent());
                sumUpPersonnels();
            });

            $('.deletePersonnel').on('click', function() {
                if ($(this).closest('#personnels').children('.personnel').length!=1) {
                    $(this).closest('.personnel').remove();
                    sumUpPersonnels();
                }
            });

            $('.personnel td:nth-child(1) input').on('keyup', function() {
                sumUpPersonnels()
            });

            function sumUpPersonnels() {
                let personnelCtr = $('#personnelCtr');
                let personnelCnt = 0;
                $('#personnels').find('.personnel').each(function() {
                    personnelCnt += parseInt($(this).find('td:nth-child(1) input').val());
                });
                personnelCtr.text(personnelCnt);
            }

            // Schedule of Fees
            $('#propertyAdministratorCharges').on('keyup', function() {
               $('#feesVat').text(parseFloat($(this).val()*0.12).toFixed(2));
               $('#totalPropertyAdministratorCharges').text(parseFloat(parseFloat($(this).val()*0.12)+parseFloat($(this).val())).toFixed(2));
            });

            // Schedule of Fee Notes

            $('#btnScheduleOfFeeNoteAdd').on('click', function() {
                let scheduleOfFeeNote = $(this).closest('#scheduleOfFeesNotes').find('.scheduleOfFeesNote').first().clone(true, true);
                scheduleOfFeeNote.find('textarea').val("");
                scheduleOfFeeNote.insertBefore($(this).parent());
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