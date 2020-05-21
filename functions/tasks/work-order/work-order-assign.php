<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

  if(checkPermission('work-order-add')) {

    $err = 0;

    $id = $_POST['id'];



    $assigned = '';
    if(isset($_POST['assigned'])) {
      $assigned = trim($_POST['assigned']);
      if(empty($assigned)) {
        $err++;
        $_SESSION['sys_assign_work_order_add_assigned_err'] = renderLang($work_orders_assigned_required);
      } else {
        $_SESSION['sys_assign_work_order_add_assigned_val'] = $assigned;
      }
    }

    $nature = '';
    if(isset($_POST['work_order_nature'])) {
      $nature = trim($_POST['work_order_nature']);
      if(strlen($nature) == 0) {
        $err++;
        $_SESSION['sys_assign_work_order_add_work_order_nature_err'] = renderLang($work_orders_work_order_nature_required);      
      } else {
        $match = 0;
        foreach($nature_of_job_arr as $key => $value) {
          if($key == $nature) {
            $match = 1;
          }
        }

        if(!$match) {
          $err++;
          $_SESSION['sys_assign_work_order_add_work_order_nature_err'] = renderLang($work_orders_valid_work_order_nature);
        } else {
          $_SESSION['sys_assign_work_order_add_work_order_nature_val'] = $nature;
        }

        if($nature == 3) {
          $nature_specify = '';
          if(isset($_POST['specify'])) {
            $nature_specify = $_POST['specify'];
            if(strlen($nature_specify) == 0) {
              $err++;
              $_SESSION['sys_assign_work_order_add_work_order_nature_err'] = renderLang($work_orders_work_order_nature_required);
              $nature_specify = '';
            } else {
              $_SESSION['sys_assign_work_order_add_work_order_nature_specify_val'] = $nature_specify;
            }
          }
        }

      }
    }

    $description = '';
    if(isset($_POST['job_particulars'])) {
      $description = trim($_POST['job_particulars']);
    }

      $status = $_POST['status'];

    $date = strtotime($date);

    if($err == 0) {

      $sql = $pdo->prepare("UPDATE task_work_order SET
        employee_id = :employee_id,
        work_order_nature = :nature,  
        work_order_description = :work_description,
        status = :status
        WHERE id =".$id);
      $sql->bindParam(":employee_id", $assigned);
      $sql->bindParam(":nature", $nature);
      $sql->bindParam(":work_description", $description);
      $sql->bindParam(":status", $status);

      $sql->execute();

      $id = $pdo->lastInsertId();

      systemLog('work-order',$id,'add','');
      $_SESSION['sys_assign_work_order_add_suc'] = renderLang($work_orders_updated_work_order);
			header('location: /work-orders');
    } else {

      $_SESSION['sys_assign_work_order_add_err'] = renderLang($form_error);
      header('location: /add-work-order');
      
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