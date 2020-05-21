<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(isset($_POST['submit-login'])){
  
  $valid_credentials = 0;

  $uname = trim($_POST['uname']);
  $upass = trim($_POST['upass']);

  if(!empty($uname) && !empty($upass)) {

    $_SESSION['sys_user_login_uname'] = $uname;

    // check unit owners table
    $unit_owner_pass = '';
    $sql = $pdo->prepare("SELECT * FROM unit_owners WHERE unit_owner_id = :uname LIMIT 1");
    $sql->bindParam(":uname", $uname);
    $sql->execute();
    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
      $unit_owner_pass = $data['upass'];
      $id = $data['id'];
			$_SESSION['sys_id'] = $data['id'];
			$_SESSION['sys_firstname'] = $data['firstname'];
      $_SESSION['sys_lastname'] = $data['lastname'];

      if(!empty($data['middlename'])) {
        $_SESSION['sys_fullname'] = $data['firstname'].' '.$data['middlename'].''.$data['lastname'];
      } else {
        $_SESSION['sys_fullname'] = $data['firstname'].' '.$data['lastname'];
      }

      if(empty($data['photo'])) {
        if($data['gender'] == 0) {
          $_SESSION['sys_photo'] = '/dist/img/avatar2.png';
        } else {
          $_SESSION['sys_photo'] = '/dist/img/avatar5.png';
        }
      } else {
        $_SESSION['sys_photo'] = '/assets/images/profile/'.$data['photo'];
      }

			$_SESSION['sys_language'] = $data['language'];
			$_SESSION['sys_account_mode'] = 'unit_owner';
			$status = $data['status'];
    }
    
    if(!empty($upass) && !empty($unit_owner_pass)) {

      if($upass == decryptStr($unit_owner_pass)) {
        $valid_credentials = 1;
      }

    }
      
    if(!$valid_credentials) {

      // check tenants table
      $tenant_pass = '';
      $sql = $pdo->prepare("SELECT * FROM tenants WHERE tenant_id = :uname LIMIT 1");
      $sql->bindParam(":uname", $uname);
      $sql->execute();
      while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
        $tenant_pass = $data['upass'];
        $id = $data['id'];
        $_SESSION['sys_id'] = $data['id'];
        $_SESSION['sys_firstname'] = $data['firstname'];
        $_SESSION['sys_lastname'] = $data['lastname'];

        if(!empty($data['middlename'])) {
          $_SESSION['sys_fullname'] = $data['firstname'].' '.$data['middlename'].''.$data['lastname'];
        } else {
          $_SESSION['sys_fullname'] = $data['firstname'].' '.$data['lastname'];
        }
  
        if(empty($data['photo'])) {
          if($data['gender'] == 0) {
            $_SESSION['sys_photo'] = '/dist/img/avatar2.png';
          } else {
            $_SESSION['sys_photo'] = '/dist/img/avatar5.png';
          }
        } else {
          $_SESSION['sys_photo'] = '/assets/images/profile/'.$data['photo'];
        }
        
        $_SESSION['sys_language'] = $data['language'];
        $_SESSION['sys_data_per_page'] = $data['data_per_page'];
        $_SESSION['sys_account_mode'] = 'tenant';
        $status = $data['status'];

      }

      if(!empty($upass) && !empty($tenant_pass)) {
        if($upass == decryptStr($tenant_pass)) {
          $valid_credentials = 1;
        }
      }

    }

    switch($status) {
      // ACTIVE
      case 0:

        if($valid_credentials) {

          if(isset($_POST['remember_me'])) {
            // set cookie for login type (username or email) and password
						setcookie('sys_user_pms', $uname.'|'.$upass, time() + (86400 * 30), "/"); // set for 1 month
          } else {
						unsetCookie('sys_user_pms'); // remove cookie if not checked
          }

          setcookie('sys_logged', 'logged_in', time() + (86400 * 30), "/");
          
          // update last login time stamp
						$last_login = time();
						switch($_SESSION['sys_account_mode']) {
							case 'unit_owner':
								$sql = $pdo->prepare("UPDATE unit_owners SET last_login=".$last_login." WHERE id=".$id);
								break;
							case 'tenant':
								$sql = $pdo->prepare("UPDATE tenants SET last_login=".$last_login." WHERE id=".$id);
								break;
						}
            $sql->execute();
            
            // redirect to user portal page
            header("location: /user-portal");

        }  else { // else redirect to login page and display error details

					$_SESSION['sys_user_login_err'] = renderLang($login_msg_err_3); // "Invalid username or password."
					header('location: /user-login');

				}

        break;
      
      // DEACTIVATED 
      case 1:
        $_SESSION['sys_user_login_err'] = renderLang($login_msg_err_6); // "Account deactivated. Please contact your web administrator."
				header('location: /user-login');
        break;

      // DELETED
      case 2:
        $_SESSION['sys_user_login_err'] = renderLang($login_msg_err_7); // "Account deleted. Please contact your web administrator."
				header('location: /user-login');
        break;

    }

  } else {
    $_SESSION['sys_login_err'] = renderLang($login_msg_err_2); // "Please fill up the form properly."
		header('location: /user-login');
  }

} else { // else redirect to login page and display error details
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_1); // "Please login properly."
	header('location: /user-login');
	
}
?>