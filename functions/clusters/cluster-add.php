<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('cluster-add')) {

        $err = 0;

        // Cluster name
        $cluster_name = '';
        if(isset($_POST['cluster_name'])) {
            $cluster_name = trim($_POST['cluster_name']);
            if(strlen($cluster_name) == 0) {
                $err++;
                $_SESSION['sys_cluster_add_cluster_name_err'] = renderLang($clusters_cluster_name_required);
            } else {

                // check if name exist
                $exist = getField('id', 'clusters', 'cluster_name = "'.$cluster_name.'" AND temp_del = 0');
                if(isset($exist)) {
                    $err++;
                    $_SESSION['sys_cluster_add_cluster_name_err'] = renderLang($clusters_cluster_name_exist);
                }
            }
        }

        // Assigned
        $assigned = 0;
        if(isset($_POST['assigned'])) {
            $assigned = trim($_POST['assigned']);
        }

        if($err == 0) {

            $sql = $pdo->prepare("INSERT INTO clusters (
                cluster_name, 
                assigned
            ) VALUES (
                :cluster_name,
                :assigned
            )");
            $sql->bindParam(":cluster_name", $cluster_name);
            $sql->bindParam(":assigned", $assigned);
            $sql->execute();

            $id = $pdo->lastInsertId();

            $_SESSION['sys_cluster_add_suc'] = renderLang($clusters_added);
            header('location: /clusters');

        } else {

            $_SESSION['sys_cluster_add_err'] = renderLang($form_error);
            header('location: /add-cluster');

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