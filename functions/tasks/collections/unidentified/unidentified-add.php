<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('unidentified-add')) {
        
        $err = 0;

        $sub_property_id = 0;
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
            if(strlen($sub_property_id) == 0) {
                $err++;
            }
        }

        $form_of_payment = '';
        if(isset($_POST['form_of_payment'])) {
            $form_of_payment = trim($_POST['form_of_payment']);
        }

        $date_deposited = '';
        if(isset($_POST['date_deposited'])) {
            $date_deposited = trim($_POST['date_deposited']);
        }

        $amount = '';
        if(isset($_POST['amount'])) {
            $amount = trim($_POST['amount']);
        }

        $bank = 0;
        if(isset($_POST['bank'])) {
            $bank = trim($_POST['bank']);
        }

        $bank_specify = '';
        if(isset($_POST['bank_specify'])) {
            $bank_specify = trim($_POST['bank_specify']);
        }

        $deposit_reference = '';
        if(isset($_POST['deposit_reference'])) {
            $deposit_reference = trim($_POST['deposit_reference']);
        }

        if($err == 0) {
            
            $sql = $pdo->prepare("INSERT INTO unidentified (
                sub_property_id, 
                form_of_payment, 
                date_deposited, 
                amount, 
                bank,
                other_bank,
                deposit_reference
            ) VALUES (
                :sub_property_id, 
                :form_of_payment, 
                :date_deposited, 
                :amount, 
                :bank,
                :other_bank,
                :deposit_reference
            )");
            $sql->bindParam(":sub_property_id", $sub_property_id);
            $sql->bindParam(":form_of_payment", $form_of_payment);
            $sql->bindParam(":date_deposited", $date_deposited);
            $sql->bindParam(":amount", $amount);
            $sql->bindParam(":bank", $bank);
            $sql->bindParam(":other_bank", $bank_specify);
            $sql->bindParam(":deposit_reference", $deposit_reference);
            $sql->execute();

            $_SESSION['sys_unidentified_add_suc'] = renderLang($unidentified_added);
            header('location: /unidentified/'.$sub_property_id);

        } else {

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