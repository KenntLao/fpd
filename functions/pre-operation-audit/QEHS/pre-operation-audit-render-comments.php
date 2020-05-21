<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-QEHS-comments')) {

        $audit_id = $_POST['audit_id'];
        $checklist_id = $_POST['checklist_id'];

        $module = 'checklist_'.$checklist_id;

        $sql = $pdo->prepare("SELECT * FROM comments WHERE module = 'pre-operation-audit-QEHS' AND module_type = :module AND module_id = :id AND temp_del = 0 ORDER BY comment_date DESC");
        $sql->bindParam(":module", $module);
        $sql->bindParam(":id", $audit_id);
        $sql->execute();
        if($sql->rowCount()) {
            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                
                if($_SESSION['sys_id'] == $data['user_id'] && $_SESSION['sys_account_mode'] == $data['user_account_mode']) {
                echo '<div class="direct-chat-msg right">';
                    echo '<div class="direct-chat-info clearfix">';

                        echo '<span class="direct-chat-name float-right">'.getFullName($data['user_id'], $data['user_account_mode']).'</span>';
                        echo '<span class="direct-chat-timestamp float-left">'.formatDate($data['comment_date'], true, false, true).'</span>';

                        echo '</div>';

                        echo '<img class="direct-chat-img" src="'.$_SESSION['sys_photo'].'" alt="message user image">';

                        echo '<div class="direct-chat-text">';
                            echo $data['comment'];
                        echo '</div>';

                echo '</div>';

                } else {

                echo '<div class="direct-chat-msg">';
                    echo '<div class="direct-chat-info clearfix">';

                        echo '<span class="direct-chat-name float-left">'.getFullName($data['user_id'], $data['user_account_mode']).'</span>';
                        echo '<span class="direct-chat-timestamp float-right">'.formatDate($data['comment_date'], true, false, true).'</span>';

                    echo '</div>';

                        if($data['user_account_mode'] == 'user') {
                            $photo = '/assets/images/profile/default.png';
                        } else {
                            $gender = getField('gender', 'employees', 'id = '.$data['user_id']);
                            $photo = getField('photo', 'employees', 'id = '.$data['user_id']);
                            if(!checkVar($photo)) {
                                switch($gender) {
                                    case 0:
                                        $photo = '/dist/img/avatar2.png';
                                        break;
                                    case 1:
                                        $photo = '/dist/img/avatar5.png';
                                }
                            }
                        }

                        echo '<img class="direct-chat-img" src="'.(!empty($photo) ? $photo : '/dist/img/avatar2.png').'" alt="message user image">';

                        echo '<div class="direct-chat-text">';
                            echo $data['comment'];
                        echo '</div>';
                echo '</div>';

                }

                    
            }
        } else {
            echo 'No Comment Yet.';
        }

    } else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);

}
?>