
<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE activity_category = 'LOI'");
$sql->execute();

if($sql->rowCount()) {

    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

        $prospect_id = $data['prospect_id'];
        $start_date = $data['activity_date'];
        $start_date = strtotime($start_date);

        $user_id = getField('created_by', 'prospecting', 'id = '.$prospect_id);
        $account_mode = getField('account_mode', 'prospecting', 'id = '.$prospect_id);

        $curr_date = time();

        $date_diff = ($curr_date - $start_date) / 86400;

        echo $date_diff;

        
        if($date_diff > 10) { // update if LOI is more than 10 days

            $sql1 = $pdo->prepare("UPDATE prospecting_activities SET 
            activity_type = 'done' 
            WHERE id = :id");
            $sql1->bindParam(":id", $data['id']);
            $sql1->execute();

        }
        
        if($date_diff > 20) { // if activity 1 is more than 10 days

            $sql1 = $pdo->prepare("SELECT id FROM prospecting_activities WHERE activity_category = 'ACT_1' AND prospect_id = :prospect_id");
            $sql1->bindParam(":prospect_id", $prospect_id);
            $sql1->execute();
            if($sql1->rowCount()) {

                $sql2 = $pdo->prepare("UPDATE prospecting_activities SET 
                activity_type = 'done' 
                WHERE prospect_id = :prospect_id");
                $sql2->bindParam(":prospect_id", $prospect_id);
                $sql2->execute();

            } else {

                $sql2 = $pdo->prepare("INSERT INTO prospecting_activities (
                    prospect_id, 
                    activity_code, 
                    activity_type, 
                    activity_category, 
                    activity_date, 
                    activity_status, 
                    activity_timeline, 
                    activity_attachment
                ) VALUES (
                    :prospect_id, 
                    :code, 
                    'done', 
                    'ACT_1', 
                    '', 
                    'Missed',
                    '', 
                    ''
                )");
                $code = 'ACT_1'.$prospect_id.'1';
                $sql2->bindParam(":prospect_id", $prospect_id);
                $sql2->bindParam(":code", $code);
                $sql2->execute();

            }

        }

        if($date_diff > 30) { // if activity 2 is more than 10 days

            $sql1 = $pdo->prepare("SELECT id FROM prospecting_activities WHERE activity_category = 'ACT_2' AND prospect_id = :prospect_id");
            $sql1->bindParam(":prospect_id", $prospect_id);
            $sql1->execute();
            if($sql1->rowCount()) {

                $sql2 = $pdo->prepare("UPDATE prospecting_activities SET 
                activity_type = 'done' 
                WHERE prospect_id = :prospect_id");
                $sql2->bindParam(":prospect_id", $prospect_id);
                $sql2->execute();

            } else {

                $sql2 = $pdo->prepare("INSERT INTO prospecting_activities (
                    prospect_id, 
                    activity_code, 
                    activity_type, 
                    activity_category, 
                    activity_date, 
                    activity_status, 
                    activity_timeline, 
                    activity_attachment
                ) VALUES (
                    :prospect_id, 
                    :code, 
                    'done', 
                    'ACT_2', 
                    '', 
                    'Missed',
                    '', 
                    ''
                )");
                $code = 'ACT_2'.$prospect_id.'1';
                $sql2->bindParam(":prospect_id", $prospect_id);
                $sql2->bindParam(":code", $code);
                $sql2->execute();

            }

        }

        if($date_diff > 40) { // if activity 3 is more than 10 days

            $sql1 = $pdo->prepare("SELECT id FROM prospecting_activities WHERE activity_category = 'ACT_3' AND prospect_id = :prospect_id");
            $sql1->bindParam(":prospect_id", $prospect_id);
            $sql1->execute();
            if($sql1->rowCount()) {

                $sql2 = $pdo->prepare("UPDATE prospecting_activities SET 
                activity_type = 'done' 
                WHERE prospect_id = :prospect_id");
                $sql2->bindParam(":prospect_id", $prospect_id);
                $sql2->execute();

            } else {

                $sql2 = $pdo->prepare("INSERT INTO prospecting_activities (
                    prospect_id, 
                    activity_code, 
                    activity_type, 
                    activity_category, 
                    activity_date, 
                    activity_status, 
                    activity_timeline, 
                    activity_attachment
                ) VALUES (
                    :prospect_id, 
                    :code, 
                    'done', 
                    'ACT_3', 
                    '', 
                    'Missed',
                    '', 
                    ''
                )");
                $code = 'ACT_3'.$prospect_id.'1';
                $sql2->bindParam(":prospect_id", $prospect_id);
                $sql2->bindParam(":code", $code);
                $sql2->execute();

            }

        }

        // notification
        if($date_diff > 10 && $date_diff < 20) {
            push_notification('prospecting_activities', $prospect_id, $user_id, $account_mode, 'Letter of intent passed 10 days');
        }

        if($date_diff > 20 && $date_diff < 30) {
            push_notification('prospecting_activities', $prospect_id, $user_id, $account_mode, 'Activity 1 passed 10 days');
        }

        if($date_diff > 30 && $date_diff < 40) {
            push_notification('prospecting_activities', $prospect_id, $user_id, $account_mode, 'Activity 2 passed 10 days');
        }

        if($date_diff > 40) {
            push_notification('prospecting_activities', $prospect_id, $user_id, $account_mode, 'Activity 3 passed 10 days');
        }

    }

} else {
    echo 'no data';
}

?>