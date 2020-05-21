<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-collection-add') || checkPermission('daily-collection-edit')) {

        $err = 0;

        $unit_id = $_POST['unit_id'];

        $sql = $pdo->prepare("SELECT t.id, t.firstname, t.middlename, t.lastname FROM unit_tenants ut LEFT JOIN tenants t ON(ut.tenant_id = t.id) WHERE unit_id = :unit_id AND t.temp_del = 0");
        $sql->bindParam(":unit_id", $unit_id);
        $sql->execute();
        if($sql->rowCount()) {
            $num = 0;
            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo '<option '.($num == 0 ? 'selected' : '').' value="'.$data['id'].'">'.getFullName($data['id'], 'tenant').'</option>';
                $num++;
            }
        }

    } else {// permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        echo 'invalid-permission';

    }

} else {// no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    echo 'no-session';

}
?>