<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('cluster-edit')) {

        $err = 0;

        // Cluster ID
        $id = $_POST['id'];

        // Cluster name
        $cluster_name = '';
        if(isset($_POST['cluster_name'])) {
            $cluster_name = trim($_POST['cluster_name']);
            if(strlen($cluster_name) == 0) {
                $err++;
                $_SESSION['sys_cluster_add_cluster_name_err'] = renderLang($clusters_cluster_name_required);
            } else {

                // check if name exist
                $curr_name = getField('cluster_name', 'clusters', 'id = '.$id);
                $exist = getField('cluster_name', 'clusters', 'cluster_name = "'.$cluster_name.'" AND temp_del = 0');
                if(isset($exist)) {
                    if($cluster_name != $exist) {
                        $err++;
                        $_SESSION['sys_cluster_add_cluster_name_err'] = renderLang($clusters_cluster_name_exist);
                    }
                }

            }
        }

        // Assigned
        $assigned = 0;
        if(isset($_POST['assigned'])) {
            $assigned = trim($_POST['assigned']);
        }

        if($err == 0) {

            $curr_data = getData($id, 'clusters');

            // check for changes
            $change_logs = array();
            if($cluster_name != $curr_data['cluster_name']) {
                $tmp = 'clusters_cluster_name::'.$curr_data['cluster_name'].'=='.$cluster_name;
                array_push($change_logs,$tmp);
            }
            if($assigned != $curr_data['assigned']) {
                $tmp = 'clusters_assigned::'.$curr_data['assigned'].'=='.$assigned;
                array_push($change_logs,$tmp);
            }

            if(count($change_logs) > 0) {

                $sql = $pdo->prepare("UPDATE clusters SET 
                    cluster_name = :cluster_name, 
                    assigned = :assigned
                WHERE id = :id");
                $sql->bindParam(":id", $id);
                $sql->bindParam(":cluster_name", $cluster_name);
                $sql->bindParam(":assigned", $assigned);
                $sql->execute();

                $_SESSION['sys_cluster_add_suc'] = renderLang($clusters_added);
                header('location: /clusters');


            } else {

                $_SESSION['sys_cluster_add_err'] = renderLang($form_no_changes);
                header('location: /edit-cluster/'.$id);

            }

        } else {

            $_SESSION['sys_cluster_add_err'] = renderLang($form_error);
            header('location: /add-cluster/'.$id);

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