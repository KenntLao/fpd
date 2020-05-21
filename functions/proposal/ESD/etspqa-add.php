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

        $reference_number = '';
        if(isset($_POST['reference_number'])){
            $reference_number = trim($_POST['reference_number']);
            if(strlen($reference_number) == 0) {
                $err++;
            }
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

        $add = $pdo->prepare("INSERT INTO proposal_esd_etspqa (prospect_id, reference_number, clientName, address_line1, address_line2, payment_terms, validity_period, signatoryName, signatoryPosition, signatoryDepartment, letter_subject, date, conformeSignatoryName, conformeSignatoryContact, status) VALUES (:prospect_id, :reference_number, :client_name, :address_line1, :address_line2, :payment_terms, :validity_period, :signatoryName, :signatoryPosition, :signatoryDepartment, :letter_subject, :date, :conformeSignatoryName, :conformeSignatoryContact, :status)");
        $add->bindParam(":prospect_id", $prospect_id);
        $add->bindParam(":reference_number", $reference_number);
        $add->bindParam(":client_name", $clientName);
        $add->bindParam(":address_line1", $addressLine1);
        $add->bindParam(":address_line2", $addressLine2);
        $add->bindParam(":payment_terms", $payment_terms);
        $add->bindParam(":validity_period", $validity_period);
        $add->bindParam(":signatoryName", $signatoryName);
        $add->bindParam(":signatoryPosition", $signatoryPosition);
        $add->bindParam(":signatoryDepartment", $signatoryDepartment);
        $add->bindParam(":conformeSignatoryName", $conformeSignatoryName);
        $add->bindParam(":conformeSignatoryContact", $conformeSignatoryContact);
        $add->bindParam(":letter_subject", $letter_subject);
        $add->bindParam(":date", $date);
        $add->bindParam(":status", $status);
        $add->execute();

        $latestId = $pdo->lastInsertId();
        $objectiveCtr = 1;
        foreach ($_POST['objective'] as $objective) {
            $addObjectives = $pdo->prepare('INSERT INTO proposal_esd_etspqa_ts_objectives (proposal_id, number, objective) VALUES (:proposal_id, :number, :objective)');
            $addObjectives->bindParam(':proposal_id', $latestId);
            $addObjectives->bindParam(':number', $objectiveCtr);
            $addObjectives->bindParam(':objective', $objective);
            $addObjectives->execute();
            $objectiveCtr+=1;
        }

        $scopeCtr = 1;
        foreach ($_POST['scope'] as $scope) {
            $addScope = $pdo->prepare('INSERT INTO proposal_esd_etspqa_scopes (proposal_id, number, scope) VALUES (:proposal_id, :number, :scope)');
            $addScope->bindParam(":proposal_id", $latestId);
            $addScope->bindParam(":number", $scopeCtr);
            $addScope->bindParam(":scope", $scope['name']);
            $addScope->execute();
            $scopeId = $pdo->lastInsertId();
            $taskCtr = 1;
            foreach ($scope['tasks'] as $task) {
                $addTask = $pdo->prepare('INSERT INTO proposal_esd_etspqa_tasks (scope_id, number, task) VALUES (:scope_id, :number, :task)');
                $addTask->bindParam(":scope_id", $scopeId);
                $addTask->bindParam(":number", $taskCtr);
                $addTask->bindParam(":task", $task);
                $addTask->execute();
                $taskCtr+=1;
            }
            $scopeCtr += 1;
        }

        $addPQASOW = '';
        if(isset($_POST['pqaScopeOfWork'])) {
            $addPQASOW = trim($_POST['pqaScopeOfWork']);
        }

        $addPQASOWq = $pdo->prepare('INSERT INTO proposal_esd_etspqa_psa_scopes (proposal_id, scope) VALUES (:proposal_id, :scope)');
        $addPQASOWq->bindParam(":proposal_id", $latestId);
        $addPQASOWq->bindParam(":scope", $addPQASOW);
        $addPQASOWq->execute();

        $pqaCtr = 1;
        foreach ($_POST['pqa'] as $pqa) {
            $addPqa = $pdo->prepare('INSERT INTO proposal_esd_etspqa_items (proposal_id, number, item) VALUES (:proposal_id, :number, :item)');
            $addPqa->bindParam(":proposal_id", $latestId);
            $addPqa->bindParam(":number", $pqaCtr);
            $addPqa->bindParam(":item", $pqa['item']);
            $addPqa->execute();
            $pqaId = $pdo->lastInsertId();
            $pqaSICtr = 1;
            foreach ($pqa['subitem'] as $subitem) {
                $addTask = $pdo->prepare('INSERT INTO proposal_esd_etspqa_subitems (item_id, number, subitem) VALUES (:item_id, :number, :subitem)');
                $addTask->bindParam(":item_id", $pqaId);
                $addTask->bindParam(":number", $pqaSICtr);
                $addTask->bindParam(":subitem", $subitem);
                $addTask->execute();
                $pqaSICtr+=1;
            }
            $pqaCtr+=1;
        }

        header("Location: /esd-etspqa-list");

    } else { // no session found, redirect to login page

        $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
        echo 'no-session';

    }
}
?>
