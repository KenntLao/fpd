<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

  // check permission to access this page or function
	if(checkPermission('task-add')) {

    $err = 0;

    $property_id = '';
    if(isset($_POST['property'])) {
      $property_id = trim($_POST['property']);
      if(empty($property_id)) {
        $err++;
        $_SESSION['sys_task_add_property_err'] = 'Property is required';
      }
    }

    $building_id = '';
    if(isset($_POST['building'])){
      $building_id = trim($_POST['building']);
      if(empty($building_id)) {
        $err++;
        $_SESSION['sys_task_add_building_err'] = 'Building is required';
      }
    }

    $type = '';
    if(isset($_POST['type'])) {
      $type = trim($_POST['type']);
      if(empty($type)){
        $err++;
        $_SESSION['sys_task_add_type_err'] = 'Type is required';
      }
    }

    $title = '';
    if(isset($_POST['title'])) {
      $title = trim($_POST['title']);
      if(empty($title)) {
        $err++;
        $_SESSION['sys_task_add_title_err'] = 'Title is required';
      }
    }

    $description = '';
    if(isset($_POST['description'])) {
      $description = trim($_POST['description']);
      if(empty($description)) {
        $err++;
        $_SESSION['sys_task_add_description_err'] = 'Description is required';
      }
    }

    $start = '';
    if(isset($_POST['start'])) {
      $start = trim($_POST['start']);
      if(empty($start)){
        $err++;
        $_SESSION['sys_task_add_start_err'] = 'Schedule is required';
      }
    }

    $due = '';
    if(isset($_POST['due'])) {
      $due = trim($_POST['due']);
      if(empty($due)) {
        $err++;
        $_SESSION['sys_task_add_due_err'] = 'Due date is required';
      }
    }

    $assigned = '';
    if(isset($_POST['assigned'])) {
      $assigned = $_POST['assigned'];
    } else {
      $err++;
      $_SESSION['sys_task_add_assign_err'] = 'Assignee is required';
    }

    if($err == 0) {

      $sql = $pdo->prepare("");

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