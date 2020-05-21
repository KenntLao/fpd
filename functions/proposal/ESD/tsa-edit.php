<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    // check permission to access this page or function
    if (checkPermission('proposal-esd-approve') || checkPermission('proposal-esd-update-status')) {

        $err = 0;

        // prospect_id
        $prospect_id = '';
        if(isset($_POST['prospect_id'])) {
            $prospect_id = trim($_POST['prospect_id']);
            if(strlen($prospect_id) == 0) {
                $err++;
            } else {
                $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id LIMIT 1");
                $sql->bindParam(":id", $prospect_id);
                $sql->execute();
                if($sql->rowCount()) {
                    $_data = $sql->fetch(PDO::FETCH_ASSOC);
                } else {
                    $err++;
                }
            }
        }

        $status = 0;
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
        }

        $date = '';
        if(isset($_POST['date'])) {
            $date = trim($_POST['date']);
        }

        $clientName = '';
        if(isset($_POST['clientName'])) {
            $clientName = trim($_POST['clientName']);
        }

        $addressLine1 = '';
        if(isset($_POST['addressLine1'])) {
            $addressLine1 = trim($_POST['addressLine1']);
        }

        $addressLine2 = '';
        if(isset($_POST['addressLine2'])) {
            $addressLine2 = trim($_POST['addressLine2']);
        }

        $payment_terms = '';
        if(isset($_POST['payment_terms'])) {
            $payment_terms = trim($_POST['payment_terms']);
        }

        $validity_period = '';
        if(isset($_POST['validity_period'])) {
            $validity_period = trim($_POST['validity_period']);
        }

        $signatoryName = '';
        if(isset($_POST['signatoryName'])) {
            $signatoryName = trim($_POST['signatoryName']);
        }

        $signatoryPosition = '';
        if(isset($_POST['signatoryPosition'])) {
            $signatoryPosition = trim($_POST['signatoryPosition']);
        }

        $signatoryDepartment = '';
        if(isset($_POST['signatoryDepartment'])) {
            $signatoryDepartment = trim($_POST['signatoryDepartment']);
        }

        $conformeSignatoryName = '';
        if(isset($_POST['conformeSignatoryName'])) {
            $signatoryDepartment = trim($_POST['conformeSignatoryName']);
        }

        $conformeSignatoryContact = '';
        if(isset($_POST['conformeSignatoryContact'])) {
            $signatoryDepartment = trim($_POST['conformeSignatoryContact']);
        }

        $letter_subject = '';
        if(isset($_POST['letter_subject'])) {
            $letter_subject = trim($_POST['letter_subject']);
        }

        $date = '';
        if(isset($_POST['date'])) {
            $date = trim($_POST['date']);
        }

        $id = $_POST['id'];
        $updtsaQ = $pdo->prepare("UPDATE proposal_esd_tsa
                                    SET clientName = :clientName, 
                                    address_line1 = :address_line1, 
                                    address_line2 = :address_line2, 
                                    payment_terms = :payment_terms, 
                                    validity_period = :validity_period, 
                                    signatoryName = :signatoryName, 
                                    signatoryDepartment = :signatoryDepartment,
                                    signatoryPosition = :signatoryPosition,
                                    conformeSignatoryName = :conformeSignatoryName,
                                    conformeSignatoryContact = :conformeSignatoryContact
                                    date = :date,
                                    status = :status
                                    WHERE id = :id");
        // $updtsaQ = $pdo->prepare("UPDATE proposal_esd_tsa SET status = :status WHERE id = :id");
        $updtsaQ->bindParam(":clientName", $clientName);
        $updtsaQ->bindParam(":address_line1", $addressLine1);
        $updtsaQ->bindParam(":address_line2", $addressLine2);
        $updtsaQ->bindParam(":payment_terms", $addressLine2);
        $updtsaQ->bindParam(":validity_period", $validity_period);
        $updtsaQ->bindParam(":signatoryName", $signatoryName);
        $updtsaQ->bindParam(":signatoryPosition", $signatoryPosition);
        $updtsaQ->bindParam(":signatoryDepartment", $signatoryDepartment);
        $updtsaQ->bindParam(":conformeSignatoryName", $conformeSignatoryName);
        $updtsaQ->bindParam(":conformeSignatoryDepartment", $conformeSignatoryDepartment);
        $updtsaQ->bindParam(":status", $status, PDO::PARAM_STR);
        $updtsaQ->bindParam(":id", $id, PDO::PARAM_INT);
        $updtsaQ->execute();

        $pdo->query("DELETE * FROM proposal_tsa_objectives WHERE proposal_id = ".$id);
        $objectiveCtr = 6;
        foreach ($_POST['objective'] as $objective) {
            $addObjectives = $pdo->prepare('INSERT INTO proposal_esd_tsa_objectives (proposal_id, number, objective) VALUES (:proposal_id, :number, :objective)');
            $addObjectives->bindParam(':proposal_id', $latestId);
            $addObjectives->bindParam(':number', $objectiveCtr);
            $addObjectives->bindParam(':objective', $objective);
            $addObjectives->execute();
            $objectiveCtr+=1;
        }



        header("Location: /esd-tsa-list");

    } else { // no session found, redirect to login page

        $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
        echo 'no-session';

    }
}
?>
