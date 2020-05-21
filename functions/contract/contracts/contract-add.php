<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('doc-contract-add')) {

        $err = 0;

        $sub_property_id = $_POST['sub_property_id'];

        // name_of_contractor
        $name_of_contractor = '';
        if(isset($_POST['name_of_contractor'])) {
            $name_of_contractor = trim($_POST['name_of_contractor']);
        }

        // Address
        $address = '';
        if(isset($_POST['address'])) {
            $address = trim($_POST['address']);
        }

        // type_of_service
        $type_of_service = '';
        if(isset($_POST['type_of_service'])) {
            $type_of_service = trim($_POST['type_of_service']);
        }

        // type_of_service_specify
        $type_of_service_specify = '';
        if(isset($_POST['type_of_service_specify'])) {
            $type_of_service_specify = trim($_POST['type_of_service_specify']);
        }

        // contact_person
        $contact_person = '';
        if(isset($_POST['contact_person'])) {
            $contact_person = trim($_POST['contact_person']);
        }

        // contact_number
        $contact_number = '';
        if(isset($_POST['contact_number'])) {
            $contact_number = trim($_POST['contact_number']);
        }

        // accreditation
        $accreditation = '';
        if(isset($_POST['accreditation'])) {
            $accreditation = trim($_POST['accreditation']);
        }

        // term_beginning
        $term_beginning = '';
        if(isset($_POST['term_beginning'])) {
            $term_beginning = trim($_POST['term_beginning']);
        }

        // term_beginning
        $term_ended = '';
        if(isset($_POST['term_ended'])) {
            $term_ended = trim($_POST['term_ended']);
        }

        if($err == 0) {

            $sql = $pdo->prepare("INSERT INTO document_management_contracts (
                sub_property_id, 
                contractor, 
                address, 
                type_of_service, 
                type_of_service_specify, 
                contact_person, 
                contact_number, 
                accreditation_date, 
                term_beginning_date, 
                term_ended_date
            ) VALUES (
                :sub_property_id, 
                :contractor, 
                :address, 
                :type_of_service, 
                :type_of_service_specify, 
                :contact_person, 
                :contact_number, 
                :accreditation, 
                :term_beginning, 
                :term_ended
            )");
            $sql->bindParam(":sub_property_id", $sub_property_id);
            $sql->bindParam(":contractor", $name_of_contractor);
            $sql->bindParam(":address", $address);
            $sql->bindParam(":type_of_service", $type_of_service);
            $sql->bindParam(":type_of_service_specify", $type_of_service_specify);
            $sql->bindParam(":contact_person", $contact_person);
            $sql->bindParam(":contact_number", $contact_number);
            $sql->bindParam(":accreditation", $accreditation);
            $sql->bindParam(":term_beginning", $term_beginning);
            $sql->bindParam(":term_ended", $term_ended);
            $sql->execute();

            $_SESSION['sys_doc_contract_add_suc'] = renderLang($contract_added);
            header('location: /doc-contract-list/'.$sub_property_id);

        } else {

            $_SESSION['sys_doc_contract_add_err'] = renderLang($form_error);
            header('location: /add-doc-contract/'.$sub_property_id);

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