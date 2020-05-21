<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('prospecting-add')) {

        $err = 0;

        $remarks = '';
        if(isset($_POST['remarks'])) {
            $remarks = trim($_POST['remarks']);
        }

        $prospect_id = 0;
        if(isset($_POST['prospect_id'])) {
            $prospect_id = trim($_POST['prospect_id']);
            if(strlen($prospect_id) == 0) {
                $err++;
            }
        }

        $created_by = $_SESSION['sys_id'];
        $account_mode = $_SESSION['sys_account_mode'];
        $curr_date = date('Y-m-d');

        if($err == 0) {
            
            $sql = $pdo->prepare("INSERT INTO prospecting_activity_remarks (
                prospect_id, 
                remarks, 
                created_date, 
                created_by, 
                account_mode
            ) VALUES (
                :prospect_id, 
                :remarks, 
                :created_date, 
                :created_by, 
                :account_mode
            )");
            $sql->bindParam(":prospect_id", $prospect_id);
            $sql->bindParam(":remarks", $remarks);
            $sql->bindParam(":created_date", $curr_date);
            $sql->bindParam(":created_by", $created_by);
            $sql->bindParam(":account_mode", $account_mode);
            $sql->execute();

            $other_remarks = getField('other_remarks', 'prospecting', 'id = '.$prospect_id);

            if(checkVar($other_remarks)) {
                echo '<tr>';
                    echo '<td><p>'.$other_remarks.'</p></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                echo '</tr>';
            }

            $sql = $pdo->prepare("SELECT * FROM prospecting_activity_remarks WHERE prospect_id = :id");
            $sql->bindParam(":id", $prospect_id);
            $sql->execute();
            if($sql->rowCount()) {
                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                        echo '<td><p>'.$data['remarks'].'</p></td>';
                        echo '<td>'.formatDate($data['created_date']).'</td>';
                        // remarks by
                        echo '<td>';
                            if($data['account_mode'] == 'employee') {
                                echo getField("code_name", "employees", "id = ".$data['created_by']);
                            } else {
                                echo getFullName($data['created_by'], 'user');
                            }
                        echo '</td>';
                    echo '</tr>';
                }
            } else {
                if(!checkVar($other_remarks)) {
                    echo '<tr>';
                        echo '<td colspan="3" class="text-center">'.renderLang($lang_no_data).'</td>';
                    echo '</tr>';
                }
            }

            // system log
            systemLog('prospecting_activity',$prospect_id ,'remarks', '');
            // notification

        } else {
            echo 'error';
        }

    } else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	

}
?>