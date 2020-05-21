<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$module = '';
if(isset($_POST['module'])) {
    $module = trim($_POST['module']);
}

if($module == 'QEHS-AUDIT') {

    $audit_id = '';
    if(isset($_POST['audit_id'])) {
        $audit_id = trim($_POST['audit_id']);
    }

    $checklist_id = '';
    if(isset($_POST['checklist_id'])) {
        $checklist_id = trim($_POST['checklist_id']);
    }

    $compliance = '';
    if(isset($_POST['compliance'])) {
        $compliance = trim($_POST['compliance']);
    }

    $actions = '';
    if(isset($_POST['actions'])) {
        $actions = trim($_POST['actions']);
    }

    $user_id = $_SESSION['sys_id'];

    $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_checklist WHERE audit_id = :audit_id AND checklist_id = :checklist_id LIMIT 1");
    $sql->bindParam(":audit_id", $audit_id);
    $sql->bindParam(":checklist_id", $checklist_id);
    $sql->execute();
    if($sql->rowCount()) { // update

        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $id = $data['id'];

        $sql1 = $pdo->prepare("UPDATE pre_operation_audit_checklist SET 
            compliances = :compliance, 
            actions = :actions, 
            auditor = :user_id 
        WHERE id = :id");
        $sql1->bindParam(":id", $id);
        $sql1->bindParam(":compliance", $compliance);
        $sql1->bindParam(":actions", $actions);
        $sql1->bindParam(":user_id", $user_id);
        $sql1->execute();

    } else { // insert

        $sql1 = $pdo->prepare("INSERT INTO pre_operation_audit_checklist (
            audit_id, 
            checklist_id,
            compliances, 
            actions, 
            auditor
        ) VALUES (
            :audit_id,
            :checklist_id,
            :compliance, 
            :actions, 
            :auditor
        )");
        $sql1->bindParam(":audit_id", $audit_id);
        $sql1->bindParam(":checklist_id", $checklist_id);
        $sql1->bindParam(":compliance", $compliance);
        $sql1->bindParam(":actions", $actions);
        $sql1->bindParam(":auditor", $user_id);
        $sql1->execute();

        echo 'insert';
    }

}


?>