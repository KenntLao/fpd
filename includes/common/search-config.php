<?php 
$keywords = '';
$var_k = '';
$keywords_arr = array();
if(isset($_GET['k'])) {
    $keywords = $_GET['k'];
    $var_k = '&k='.$_GET['k'];
    $keywords_arr[] = $keywords;
}

if($page == "notifications") {
    $keywords_arr = array();
    if(isset($_GET['k'])) {
        $keywords = $_GET['k'];
        $key_arr = explode(' ', $keywords);
        $user_ids = array();
        foreach($key_arr as $key) {
            $user_id = getField("id", 'users', 'temp_del = 0 AND (firstname LIKE "%'.$key.'%" OR lastname LIKE "%'.$key.'%")');
            if(checkVar($user_id)) {
                $user_ids[] = $user_id;
            }

            $employee_id = getField("id", 'employees', 'temp_del = 0 AND (firstname LIKE "%'.$key.'%" OR lastname LIKE "%'.$key.'%")');
            if(checkVar($employee_id)) {
                $user_ids[] = $employee_id;
            }
        }
        $keywords_arr = $user_ids;
    }
}

$date_range = '';
if(isset($_GET['dt'])) {
    $date_range = $_GET['dt'];
    $var_k .= '&dt='.$_GET['dt'];
}

$where = '';
if($where == '') {
    if(!empty($keywords_arr)) {
        foreach($keywords_arr as $keywords) {
            foreach($fields_arr as $field) {
                if($page == "notifications") {
                    if($where == '') {
                        $where .= "AND ($field = '$keywords'";
                    } else {
                        $where .= " OR $field = '$keywords'";
                    }
                } else {
                    if($where == '') {
                        $where .= "AND ($field LIKE '%$keywords%'";
                    } else {
                        $where .= " OR $field LIKE '%$keywords%'";
                    }
                }
            }
        }
        $where .= ")";
    }
}

if(strlen($date_range) != 0) {
    $date_range_arr = explode("-", $date_range);
    $start_date = str_replace("/", "-", $date_range_arr[0]);
    $end_date = str_replace("/", "-", $date_range_arr[1]);

    foreach($date_fields_arr as $field) {
        $where .= " AND ($field >= '$start_date' AND $field <= '$end_date')";
    }
}
?>