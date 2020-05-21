<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('notice-to-proceed-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		// PROJECT ID
		$prospect_id = $_POST['id'];

		$sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id");
		$sql->bindParam(":id",$prospect_id);
		$sql->execute();
		$_data = $sql->fetch(PDO::FETCH_ASSOC);

		$contact_person = $_data['contact_person'];
		$mobile_number = $_data['mobile_number'];

		// NOTICE OF NEW INSTRUCTIONS

		// REFERENCE DOCUMENTS
		$reference_documents = array();
		if(isset($_POST['reference_document'])) {
			$reference_document = $_POST['reference_document'];
			if(!empty($reference_document)) {
				foreach($reference_document as $value) {
					$reference_documents[] = $value;
				}
				$reference_document = implode(',',$reference_documents);
			}
		}

        // NNI REMARKS
        $nni_remarks = array();
        if(isset($_POST['nni_remarks'])) {
            $nni_remarks = $_POST['nni_remarks'];
        }

        // CLIENTS CONTACTS

		// nni_contact_person
		$nni_contact_person = array();
		if(isset($_POST['nni_contact_person'])) {
			$nni_contact_person = $_POST['nni_contact_person'];
			
		}
		// nni_designation
		$nni_designation = array();
		if(isset($_POST['nni_designation'])) {
			$nni_designation = $_POST['nni_designation'];
			
		}
		// nni_telephone
		$nni_telephone = array();
		if(isset($_POST['nni_telephone'])) {
			$nni_telephone = $_POST['nni_telephone'];
			
		}
		// nni_mobile
		$nni_mobile = array();
		if(isset($_POST['nni_mobile'])) {
			$nni_mobile = $_POST['nni_mobile'];
			
		}
		// nni_email_address
		$nni_email_address = array();
		if(isset($_POST['nni_email_address'])) {
			$nni_email_address = $_POST['nni_email_address'];
			
		}

		// CONTRACT

		// START CONTRACT
		$start_contract = '';
		if(isset($_POST['start_contract'])) {
			$start_contract = trim($_POST['start_contract']);
			
		}
		// END CONTRACT
		$end_contract = '';
		if(isset($_POST['end_contract'])) {
			$end_contract = trim($_POST['end_contract']);
			
		}

		// NNI HR INFORMATION

		// MANPOWER PLANTILLA
		$manpower_plantilla = array();
		if(isset($_POST['manpower_plantilla'])) {
			$manpower_plantilla = $_POST['manpower_plantilla'];	
		}

		// HEAD COUNT
        $head_count = array();
        if(isset($_POST['head_count'])) {
            $head_count = $_POST['head_count'];
        }

		// BUDGET BASE PAY
        $budget_base_pay = array();
        if(isset($_POST['budget_base_pay'])) {
            $budget_base_pay = $_POST['budget_base_pay'];
        }

		// BUDGET ALLOWANCE
        $budget_allowance = array();
        if(isset($_POST['budget_allowance'])) {
            $budget_allowance = $_POST['budget_allowance'];
        }

        // DEPLOYMENT DATE
        $deployment_date = array();
        if(isset($_POST['deployment_date'])) {
            $deployment_date = $_POST['deployment_date'];
        }

        // SPECIAL QUALIFICATION
        $special_qualification = array();
        if(isset($_POST['special_qualification'])) {
            $special_qualification = $_POST['special_qualification'];
        }

        // HR REMARKS
        $hr_remarks = array();
        if(isset($_POST['hr_remarks'])) {
            $hr_remarks = $_POST['hr_remarks'];
        }
		
		// HR REMARKS
        $property_administration = '';
        if(isset($_POST['property_administration'])) {
            $property_administration = $_POST['property_administration'];
        }

		// HR REMARKS
        $inclusions = array();
        if(isset($_POST['inclusions'])) {
            $inclusions = $_POST['inclusions'];
        }

		// HR REMARKS
        $terms = '';
        if(isset($_POST['terms'])) {
            $terms = $_POST['terms'];
        }

		// HR REMARKS
        $cad_remarks = '';
        if(isset($_POST['cad_remarks'])) {
            $cad_remarks = $_POST['cad_remarks'];
        }
	
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors


			$sql = $pdo->prepare("INSERT INTO notice_of_new_instructions (
				prospect_id,
				reference_documents,
				remarks
			) VALUES (
				:nni_prospect_id,
				:reference_documents,
				:nni_remarks
				
			)");
			$sql->bindParam(":nni_prospect_id", $prospect_id);
			$sql->bindParam(":nni_remarks", $nni_remarks);
			$sql->bindParam(":reference_documents", $reference_document);
			$sql->execute();

			$id = $pdo->lastInsertId();

			//INSERT NNI CLIENTS CONTACTS
			$sql = $pdo->prepare("INSERT INTO nni_clients_contacts (
				nni_id,
				contact_person,
				designation,
				telephone,
				mobile_number,
				email_address
			) VALUES (
				:nni_client_id,
				:contact_person,
				:designation,
				:telephone,
				:mobile_number,
				:email_address
				
			)");
			
			$sql->bindParam(":nni_client_id",$id);
				foreach ($nni_contact_person as $key => $nni_contact) {

					$sql->bindParam(":contact_person", $nni_contact);
					$sql->bindParam(":designation", $nni_designation[$key]);
					$sql->bindParam(":telephone", $nni_telephone[$key]);
					$sql->bindParam(":mobile_number", $nni_mobile[$key]);
					$sql->bindParam(":email_address", $nni_email_address[$key]);
					$sql->execute();
				}
      
			$sql = $pdo->prepare("INSERT INTO contract (
				prospect_id,
				contract_contact_person,
				contact_number,
				acquisition_date,
				renewal_date
			) VALUES (
				:c_prospect_id,
				:contract_contact_person,
				:contact_number,
				:acquisition_date,
				:renewal_date
				
			)");
			$sql->bindParam(":c_prospect_id", $prospect_id);
			$sql->bindParam(":contract_contact_person", $contact_person);
			$sql->bindParam(":contact_number", $mobile_number);
			$sql->bindParam(":acquisition_date", $start_contract);
			$sql->bindParam(":renewal_date", $end_contract);
			$sql->execute();


			//INSERT NNI HR INFORMATION
			$sql = $pdo->prepare("INSERT INTO nni_hr_informations (
				nni_id,
				manpower_plantilla,
				head_count,
				budget_base_pay,
				budget_allowance,
				deployment_date,
				special_qualification,
				remarks
			) VALUES (
				:nni_hr_id,
				:manpower_plantilla,
				:head_count,
				:budget_base_pay,
				:budget_allowance,
				:deployment_date,
				:special_qualification,
				:hr_remarks
				
			)");

			$sql->bindParam(":nni_hr_id",$id);
				foreach ($manpower_plantilla as $key => $plantilla) {
					if(!empty($plantilla) || !empty($head_count[$key])) {

						$sql->bindParam(":manpower_plantilla", $plantilla);
						$sql->bindParam(":head_count", $head_count[$key]);
						$sql->bindParam(":budget_base_pay", $budget_base_pay[$key]);
						$sql->bindParam(":budget_allowance", $budget_allowance[$key]);
						$sql->bindParam(":deployment_date", $deployment_date[$key]);
						$sql->bindParam(":special_qualification", $special_qualification[$key]);
						$sql->bindParam(":hr_remarks", $hr_remarks[$key]);
						$sql->execute();
					}
				}

			//INSERT PRF
			$sql = $pdo->prepare("INSERT INTO prf (
				prospect_id
			) VALUES (
				:prf_prospect_id
			)");

			$sql->bindParam(":prf_prospect_id", $prospect_id);
			$sql->execute();

			$prf_id = $pdo->lastInsertId();

			//INSERT PRF DEPARTMENTS
			$sql = $pdo->prepare("INSERT INTO prf_departments (
				prf_id,
				job_title,
				number_of_staff,
				code
			) VALUES (
				:prf_id,
				:job_title,
				:number_of_staff,
				:code
			)"); 

			$sql->bindParam("prf_id", $prf_id);

			$code = $prospect_id.$prf_id.'1';

				foreach ($manpower_plantilla as $key => $plantilla) {
					if(!empty($head_count[$key])) {
						$sql->bindParam("job_title", $plantilla);
						$sql->bindParam("number_of_staff", $head_count[$key]);
						$sql->bindParam(":code", $code);
						$sql->execute();

						$code++;

					}
				}


			//INSERT NNI CAD INFORMATION
			$sql = $pdo->prepare("INSERT INTO nni_cad_informations (
				nni_id,
				property_administration,
				inclusions,
				terms,
				remarks
			) VALUES (
				:nni_cad_id,
				:property_administration,
				:inclusions,
				:terms,
				:cad_remarks
				
			)");
			
			$sql->bindParam(":nni_cad_id",$id);
			$sql->bindParam(":property_administration", $property_administration);
			$sql->bindParam(":terms", $terms);
			$sql->bindParam(":cad_remarks", $cad_remarks);
				foreach ($inclusions as $key => $inclusion) {

					$sql->bindParam(":inclusions", $inclusion);
					$sql->execute();
				}

				// record to system log
			systemLog('nni',$id,'add','');


			$_SESSION['sys_nni_add_suc'] = renderLang($nni_created);
			header('location: /notice-to-proceed-list');
			
		} else { // error found
			
			$_SESSION['sys_notice_to_proceed_add_err'] = renderLang($form_error);
			header('location: /add-notice-to-proceed');
			
		}
		
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>