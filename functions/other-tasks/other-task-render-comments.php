<?php 
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$module_id = $_POST['module_id'];
$activity_id = $_POST['activity_id'];

$module = 'other_task_'.$activity_id;

$sql = $pdo->prepare("SELECT * FROM comments WHERE module = 'other-task' AND module_type = :module AND module_id = :id AND temp_del = 0 ORDER BY comment_date DESC");
$sql->bindParam(":module", $module);
$sql->bindParam(":id", $module_id);
$sql->execute();
if($sql->rowCount()) {
    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

        // update the comment to seen
        $account_code = $_SESSION['sys_id'].':'.$_SESSION['sys_account_mode'];
        if(checkVar($data['seen_by'])) {
            $seen_by_arr = array_filter(explode(',', $data['seen_by']));
            if(!in_array($account_code, $seen_by_arr)) {
                $seen_by_arr[] = $account_code;
                $accounts_seen = ','.implode(',', $seen_by_arr).',';
                $sql1 = $pdo->prepare("UPDATE comments SET seen_by = :account_code WHERE id = :id");
                $sql1->bindParam(":id", $data['id']);
                $sql1->bindParam(":account_code", $accounts_seen);
                $sql1->execute();
            }
        } else {
            $accounts_seen = ','.$account_code.',';
            $sql1 = $pdo->prepare("UPDATE comments SET seen_by = :account_code WHERE id = :id");
            $sql1->bindParam(":id", $data['id']);
            $sql1->bindParam(":account_code", $accounts_seen);
            $sql1->execute();
        }
        
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
?>