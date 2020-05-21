<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$err = 0;

$checklist_id = '';
if(isset($_POST['checklist_id'])) {
    $checklist_id = $_POST['checklist_id'];
    if(strlen($checklist_id) == 0) {
        $err++;
    }
}

$audit_id = '';
if(isset($_POST['audit_id'])) {
    $audit_id = $_POST['audit_id'];
    if(strlen($audit_id) == 0) {
        $err++;
    }
}

$check_status = '';
if(isset($_POST['status'])) {
    $check_status = $_POST['status'];
}

$actions = '';
if(isset($_POST['actions'])) {
    $actions = $_POST['actions'];
    if(strlen($actions) == 0) {
    }
}

$compliance = '';
if(isset($_POST['compliance'])) {
    $compliance = $_POST['compliance'];
    if(strlen($compliance) == 0) {
    }
}

$color = 0;
if(isset($_POST['color'])) {
    $color = trim($_POST['color']);
}

$code = $audit_id.$checklist_id;

if($err == 0) {

    $sql = $pdo->prepare("SELECT id, compliances, actions, auditor FROM pre_operation_audit_checklist WHERE audit_id = :audit_id AND checklist_id = :checklist_id");
    $sql->bindParam(":audit_id", $audit_id);
    $sql->bindParam(":checklist_id", $checklist_id);
    $sql->execute();
    if($sql->rowCount()) { // update if exist

        $sql1 = $pdo->prepare("UPDATE pre_operation_audit_checklist SET 
            audit_id = :audit_id, 
            checklist_id = :checklist_id, 
            check_status = :check_status,
            color_code = :color,
            auditor = :auditor
            WHERE audit_id = :audit_id AND checklist_id = :checklist_id");
        $sql1->bindParam(":audit_id", $audit_id);
        $sql1->bindParam(":checklist_id", $checklist_id);
        $sql1->bindParam(":check_status", $check_status);
        $sql1->bindParam(":color", $color);
        $sql1->bindParam(":auditor", $auditor);
        $sql1->execute();

    } else { //insert if not exist

        $sql2 = $pdo->prepare("INSERT INTO pre_operation_audit_checklist (
            audit_id, 
            checklist_id, 
            check_status,
            color_code, 
            compliances, 
            actions,
            auditor
        ) VALUES (
            :audit_id, 
            :checklist_id, 
            :check_status,
            :color,
            :compliance, 
            :actions,
            :auditor
        )");
        $sql2->bindParam(":audit_id", $audit_id);
        $sql2->bindParam(":checklist_id", $checklist_id);
        $sql2->bindParam(":check_status", $check_status);
        $sql2->bindParam(":color", $color);
        $sql2->bindParam(":compliance", $compliance);
        $sql2->bindParam(":actions", $actions);
        $sql2->bindParam(":auditor", $_SESSION['sys_id']);
        $sql2->execute();

    }

    echo $check_status;

}

?>