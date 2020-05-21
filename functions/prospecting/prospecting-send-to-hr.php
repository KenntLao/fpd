<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$err_msg = '';


$err = 0;

$prospect_id = 0;
if(isset($_POST['prospect_id'])) {
    $prospect_id = trim($_POST['prospect_id']);
    if(empty($prospect_id)) {
        $err++;
    }
}

$plantilla = array();
if(isset($_POST['plantilla'])) {
    $plantilla = $_POST['plantilla'];
} else {
    $err++;
}

$head_count = array();
if(isset($_POST['head_count'])) {
    $head_count = $_POST['head_count'];
}

$base_pay = array();
if(isset($_POST['base_pay'])) {
    $base_pay = $_POST['base_pay'];
}

$allowance = array();
if(isset($_POST['allowance'])) {
    $allowance = $_POST['allowance'];
}

$qualification = array();
if(isset($_POST['qualification'])) {
    $qualification = $_POST['qualification'];
}

$remarks = array();
if(isset($_POST['remarks'])) {
    $remarks = $_POST['remarks'];
}

$user_id = $_SESSION['sys_id'];
$account_mode = $_SESSION['sys_account_mode'];

if($err == 0) {

    $sql = $pdo->prepare("INSERT INTO prospecting_hr_information (
        prospect_id, 
        manpower_plantilla, 
        head_count, 
        base_pay, 
        allowance, 
        special_qualification, 
        remarks,
        send_by,
        account_mode, 
        created_at
    ) VALUES (
        :prospect_id, 
        :plantilla, 
        :head_count, 
        :base_pay, 
        :allowance, 
        :qualification, 
        :remarks, 
        :user_id, 
        :account_mode, 
        :created_at
    )");

    $curr_date = time();

    $sql->bindParam(":prospect_id", $prospect_id);
    $sql->bindParam(":user_id", $user_id);
    $sql->bindParam(":account_mode", $account_mode);
    $sql->bindParam(":created_at", $curr_date);

    $ins = 0;

    foreach($plantilla as $key => $plan) {

        if(!empty($plan)) {

            

            $sql->bindParam(":plantilla", $plan);
            $sql->bindParam(":head_count", $head_count[$key]);
            $sql->bindParam(":base_pay", $base_pay[$key]);
            $sql->bindParam(":allowance", $allowance[$key]);
            $sql->bindParam(":qualification", $qualification[$key]);
            $sql->bindParam(":remarks", $remarks[$key]);
            $sql->execute();
        
            $ins++;
        }

    }

    if($ins > 0) {

        $err_msg = 'success';

    } else {
        $err_msg = 'error';
    }

} else {
    $err_msg = 'error';
}

echo $err_msg;
?>