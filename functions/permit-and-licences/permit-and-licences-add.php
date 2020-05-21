<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('permits-licences-add')) {

        $err = 0;

        // property id
            $property_id = '';
            if(isset($_POST['property'])) {
                $property_id = trim($_POST['property']);
                if(strlen($property_id) == 0) {
                    $err++;
                }
            }
        // 

        // permits and licences
            $permit_ids = array();
            if(isset($_POST['permit_id'])) {
                $permit_ids = $_POST['permit_id'];
            }

            $permit_number = array();
            if(isset($_POST['permit_number'])) {
                $permit_number = $_POST['permit_number'];
            }

            $date_issued = array();
            if(isset($_POST['date_issued'])) {
                $date_issued = $_POST['date_issued'];
            }

            $remarks = array();
            if(isset($_POST['remarks'])) {
                $remarks = $_POST['remarks'];
            }

            $date_submitted = array();
            if(isset($_POST['date_submitted'])) {
                $date_submitted = $_POST['date_submitted'];
            }
        // 
        
        // TSA permit licences

            $tsa_licence_id = array();
            if(isset($_POST['tsa_licence_id'])) {
                $tsa_licence_id = $_POST['tsa_licence_id'];
            }

            $permits_licences_id = array();
            if(isset($_POST['permits_licences_id'])) {
                $permits_licences_id = $_POST['permits_licences_id'];
            }

            $tsa_licence_status = array();
            if(isset($_POST['tsa_licence_status'])) {
                $tsa_licence_status = $_POST['tsa_licence_status'];
            }

        // 

        // check for error
        if($err == 0) {

            // insert in operation permits
                // check if exist
                $permit_id = 0;
                $sql = $pdo->prepare("SELECT * FROM operation_permits WHERE property_id = :property_id AND temp_del = 0 LIMIT 1");
                $sql->bindParam(":property_id", $property_id);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $permit_id = $data['id'];

                    $sql1 = $pdo->prepare("UPDATE operation_permits SET 
                        property_id = :property_id 
                    WHERE id  = :permit_id");
                    $sql1->bindParam(":permit_id", $permit_id);
                    $sql1->bindParam(":property_id", $property_id);
                    $sql1->execute();

                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO operation_permits (
                        property_id
                    ) VALUES (
                        :property_id
                    )");

                    $sql1->bindParam(":property_id", $property_id);
                    $sql1->execute();

                    $permit_id = $pdo->lastInsertId();

                }
            // 

            // insert in permits and licences

                foreach($permit_ids as $key => $value) {

                    $sql = $pdo->prepare("SELECT * FROM operation_permits_licences WHERE permit_id = :permit_id AND permit_licences_id = :licences LIMIT 1");
                    $sql->bindParam(":permit_id", $permit_id);
                    $sql->bindParam(":licences", $value);
                    $sql->execute();
                    if($sql->rowCount()) { // update

                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                        $id = $data['id'];

                        $sql1 = $pdo->prepare("UPDATE operation_permits_licences SET 
                            permit_number = :permit_number, 
                            date_issued = :date_issued, 
                            remarks = :remarks, 
                            date_submitted = :date_submitted 
                        WHERE id = :id");
                        $sql1->bindParam(":id", $id);
                        $sql1->bindParam(":permit_number", $permit_number[$key]);
                        $sql1->bindParam(":date_issued", $date_issued[$key]);
                        $sql1->bindParam(":remarks", $remarks[$key]);
                        $sql1->bindParam(":date_submitted", $date_submitted[$key]);
                        $sql1->execute();

                    } else { // insert

                        $sql1 = $pdo->prepare("INSERT INTO operation_permits_licences (
                            permit_id, 
                            permit_licences_id, 
                            permit_number, 
                            date_issued, 
                            remarks, 
                            date_submitted
                        ) VALUES (
                            :permit_id, 
                            :licence_id, 
                            :permit_number, 
                            :date_issued, 
                            :remarks, 
                            :date_submitted
                        )");
                        $sql1->bindParam(":permit_id", $permit_id);
                        $sql1->bindParam(":licence_id", $value);
                        $sql1->bindParam(":permit_number", $permit_number[$key]);
                        $sql1->bindParam(":date_issued", $date_issued[$key]);
                        $sql1->bindParam(":remarks", $remarks[$key]);
                        $sql1->bindParam(":date_submitted", $date_submitted[$key]);
                        $sql1->execute();

                    }

                }

            // 

            // update or insert in TSA permits

                foreach($tsa_licence_id as $key => $tsa_permit_id) {

                    $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_permit_licences WHERE id = :id LIMIT 1");
                    $sql->bindParam(":id", $tsa_permit_id);
                    $sql->execute();
                    if($sql->rowCount()) { // update

                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                        $licence_id = $data['id'];

                        $sql1 = $pdo->prepare("UPDATE pre_operation_audit_tsa_permit_licences SET 
                            particulars = :permits_licences_id,
                            status = :tsa_licence_status
                        WHERE id = :id");
                        $sql1->bindParam(":id", $licence_id);
                        $sql1->bindParam(":permits_licences_id", $permits_licences_id[$key]);
                        $sql1->bindParam(":tsa_licence_status", $tsa_licence_status[$key]);
                        $sql1->execute();

                    } else { // insert

                    }

                }

            // 

            $_SESSION['sys_permit_licences_add_suc'] = renderLang($permits_and_licences_saved);
            header('location: /edit-permits-and-licences/'.$property_id);

        } else {

            $_SESSION['sys_permit_licences_add_err'] = renderLang($permits_and_licences_saved);
            header('location: /edit-permits-and-licences/'.$property_id);

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