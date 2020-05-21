<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

  if(checkPermission('work-order-add')) {

    $err = 0;

    $work_order_no = '';
    if(isset($_POST['work-order-no'])) {
      $work_order_no = trim($_POST['work-order-no']);
      if(empty($work_order_no)) {
        $err++;
        $_SESSION['sys_work_order_add_work_order_no_err'] = renderLang($work_orders_work_order_no_required);
      } else {
        // check if exist
        $sql = $pdo->prepare("SELECT id FROM task_work_order WHERE work_order_no = :work_order_no");
        $sql->bindParam(":work_order_no", $work_order_no);
        $sql->execute();
        if($sql->rowCount()) {
          $err++;
          $_SESSION['sys_work_order_add_work_order_no_err'] = renderLang($work_orders_work_order_no_exist);
        }
      }
    }

    $date = '';
    if(isset($_POST['date'])) {
      $date = trim($_POST['date']);
      if(empty($date)) {
        $err++;
        $_SESSION['sys_work_order_add_date_err'] = renderLang($work_orders_date_required);
      } else {
        $_SESSION['sys_work_order_add_date_val'] = $date;
      }
    }

    $assigned = '';
    if(isset($_POST['assigned'])) {
      $assigned = trim($_POST['assigned']);
      if(empty($assigned)) {
        $err++;
        $_SESSION['sys_work_order_add_assigned_err'] = renderLang($work_orders_assigned_required);
      } else {
        $_SESSION['sys_work_order_add_assigned_val'] = $assigned;
      }
    }

    $nature = '';
    if(isset($_POST['work_order_nature'])) {
      $nature = trim($_POST['work_order_nature']);
      if(strlen($nature) == 0) {
        $err++;
        $_SESSION['sys_work_order_add_work_order_nature_err'] = renderLang($work_orders_work_order_nature_required);      
      } else {
        $match = 0;
        foreach($nature_of_job_arr as $key => $value) {
          if($key == $nature) {
            $match = 1;
          }
        }

        if(!$match) {
          $err++;
          $_SESSION['sys_work_order_add_work_order_nature_err'] = renderLang($work_orders_valid_work_order_nature);
        } else {
          $_SESSION['sys_work_order_add_work_order_nature_val'] = $nature;
        }

        if($nature == 3) {
          $nature_specify = '';
          if(isset($_POST['specify'])) {
            $nature_specify = $_POST['specify'];
            if(strlen($nature_specify) == 0) {
              $err++;
              $_SESSION['sys_work_order_add_work_order_nature_err'] = renderLang($work_orders_work_order_nature_required);
              $nature_specify = '';
            } else {
              $_SESSION['sys_work_order_add_work_order_nature_specify_val'] = $nature_specify;
            }
          }
        }

      }
    }

    $description = '';
    if(isset($_POST['job_particulars'])) {
      $description = trim($_POST['job_particulars']);
    }

    $unit_id = '';
    if(isset($_POST['unit'])) {
      $unit_id = trim($_POST['unit']);
      if(strlen($unit_id) != 0) {
        $_SESSION['sys_work_order_add_unit_val'] = $unit_id;
      }
    }

    $requestor = '';
    if(isset($_POST['requested_by'])) {
      $requestor = trim($_POST['requested_by']);
      if(strlen($requestor) == 0) {
        $err++;
        $_SESSION['sys_work_order_add_requested_by_err'] = renderLang($work_orders_requested_by_required);
      } else {
        $requestor = explode(',',$requestor);
        $requestor_id = $requestor[0];
        $requestor_account_mode = $requestor[1];
        $_SESSION['sys_work_order_add_requested_by_val'] = $requestor;
      }
    }
    $date = strtotime($date);

    if($err == 0) {

      $sql = $pdo->prepare("INSERT INTO task_work_order 
        (work_order_no,
        employee_id,
        requestor_id,
        requestor_account_mode,
        work_order_date, 
        work_order_nature, 
        work_order_nature_specify, 
        work_order_description) 
      VALUES 
      ( :work_order_no,
        :employee_id,
        :requestor_id,
        :requestor_account_mode,
        :date, 
        :nature, 
        :nature_specify, 
        :work_description)");

      $sql->bindParam(":work_order_no", $work_order_no);
      $sql->bindParam(":employee_id", $assigned);
      $sql->bindParam(":requestor_id", $requestor_id);
      $sql->bindParam(":requestor_account_mode", $requestor_account_mode);
      $sql->bindParam(":date", $date);
      $sql->bindParam(":nature", $nature);
      $sql->bindParam(":nature_specify", $nature_specify);
      $sql->bindParam(":work_description", $description);

      $sql->execute();

      $id = $pdo->lastInsertId();

      systemLog('work-order',$id,'add','');
      $_SESSION['sys_work_order_add_suc'] = renderLang($work_orders_work_order_added);
			header('location: /add-work-order');
    } else {

      $_SESSION['sys_work_order_add_err'] = renderLang($form_error);
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