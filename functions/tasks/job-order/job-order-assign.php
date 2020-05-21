<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('property-add')) {

        $err = 0;

        $id = $_POST['id'];

        $assigned = '';
        if(isset($_POST['assigned'])) {
            $assigned = trim($_POST['assigned']);
            if(strlen($assigned) == 0) {
                $err++;
                $_SESSION['sys_assign_job_order_add_assigned_err'] = renderLang($job_orders_assigned_required);
            } else {
                $_SESSION['sys_assign_job_order_add_assigned_val'] = $assigned;
            }
        }

        $description = '';
        if(isset($_POST['job_particulars'])) {
            $description = trim($_POST['job_particulars']);
            $_SESSION['sys_assign_job_order_add_description_val'] = $description;
        }

        $status = '';
        if(isset($_POST['status'])) {
            $status = $_POST['status'];
            $_SESSION['sys_assign_job_order_add_status_val'] = $status;
        }

        if($err == 0) {

            $sql = $pdo->prepare("UPDATE task_job_order SET 
                 status = :status,
                assigned = :assigned,
                job_order_description = :job_description
            WHERE id = ".$id);

            $sql->bindParam(":status", $status);
            $sql->bindParam(":assigned", $assigned);
            $sql->bindParam(":job_description", $description);
            $sql->execute();
      
            systemLog('job-order',$id,'add','');
            $_SESSION['sys_assign_job_order_add_suc'] = renderLang($job_orders_updated);
            header('location: /job-orders');
        } else {
      
            $_SESSION['sys_assign_job_order_add_err'] = renderLang($form_error);
            header('location: /add-job-order');
            
        }

    } else {// permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        header('location: /dashboard');
    
    }

} else {// no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    header('location: /');
  
}
?>