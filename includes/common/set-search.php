<?php
// set variables
$keywords = '';
$where = '';
$var_k = '';

// set redirect link for clearing search bar
$redirect_link = $page;
if(isset($subpage)) {
	$redirect_link = $subpage;
}

// get user defined keywords if any
if(isset($_GET['k'])) {
	$keywords = trim($_GET['k']);
	$var_k = '&k='.urlencode($_GET['k']);
}
if($page != 'system-log') {
    if($keywords != '') {
        $keywords_arr = explode(' ',$keywords);
    }
} else {
    if($keywords != '') {
        $keywords_arr[] = $keywords;
    }
}

if($page == 'system-log') {

    if(isset($_GET['k'])) {
        $user_ids = array();
        foreach($keywords_arr as $keyword) {
            $user_id = getField('id', 'users', "firstname LIKE '%$keyword%' OR lastname LIKE '%$keyword%'");
            if(checkVar($user_id)) {
                $user_ids[] = $user_id;
            }
            $employee_id = getField('id', 'employees', "firstname LIKE '%$keyword%' OR lastname LIKE '%$keyword%'");
            if(checkVar($employee_id)) {
                $user_ids[] = $employee_id;
            }
        }
        if(!empty($user_ids)) {
            $keywords_arr = array();
            $keywords_arr = $user_ids;
        }
    }
}


$sql_department_id = '';
//if($page == 'employees' && $_SESSION['sys_account_mode'] == 'employee') {
//	$sql_department_id = ' AND department_id='.$_SESSION['sys_department_id'];
//}
$sql_property_id = '';
//if($page == 'employees' && $_SESSION['sys_account_mode'] == 'employee') {
//	$sql_property_id = ' AND property_id='.$_SESSION['sys_property_id'];
//}

$sql_temp_del = '';
if($page != 'system-log') {
	$sql_temp_del = ' AND temp_del=0';
}

if(!isset($query_mode)) {
	// if keywords array exists, create the WHERE clause for query
	if(isset($keywords_arr)) {
		foreach($keywords_arr as $keyword) {
			$keyword = str_replace("'","''",$keyword);
			if($where == '') {
				foreach($fields_arr as $field) {
                    if($field == 'user_id') {
                        if($where == '') {
                            $where .= " WHERE ".$field." = '".$keyword."'".$sql_department_id.$sql_property_id.$sql_temp_del;
                        } else {
                            $where .= " OR ".$field." = '".$keyword."'".$sql_department_id.$sql_property_id.$sql_temp_del;
                        }
                    } else if($field == 'FROM_UNIXTIME(epoch_time)') {
                        if(strtotime($keyword)) {
                            if($where == '') {
                                $where .= " WHERE ".$field." LIKE '%".$keyword."%'".$sql_department_id.$sql_property_id.$sql_temp_del;
                            } else {
                                $where .= " OR ".$field."LIKE '%".$keyword."%'".$sql_department_id.$sql_property_id.$sql_temp_del;
                            }
                        }
                    }  else {
                        if($where == '') {
                            $where .= " WHERE ".$field." LIKE '%".$keyword."%'".$sql_department_id.$sql_property_id.$sql_temp_del;
                        } else {
                            $where .= " OR ".$field." LIKE '%".$keyword."%'".$sql_department_id.$sql_property_id.$sql_temp_del;
                        }
                    }
				}
			} else {
				foreach($fields_arr as $field) {
                    if($field == 'user_id') {
                        $where .= " OR ".$field." = '".$keyword."'".$sql_department_id.$sql_property_id.$sql_temp_del;
                    } else if($field == 'FROM_UNIXTIME(epoch_time)') {
                        $where .= " OR ".$field." = '%".$keyword."%'".$sql_department_id.$sql_property_id.$sql_temp_del;
                    } else {
                        $where .= " OR ".$field." LIKE '%".$keyword."%'".$sql_department_id.$sql_property_id.$sql_temp_del;
                    }
				}
			}
		}
	} else {
		if($where == '' && $page != 'system-log') {
			$where = " WHERE temp_del = 0".$sql_department_id.$sql_property_id;
		} else {
			$where .= $sql_department_id.$sql_property_id.$sql_temp_del;
		}
	}
} else {
	switch($query_mode) {
		case 'sub-property-units':
			if(isset($keywords_arr)) {
				foreach($keywords_arr as $keyword) {
					$keyword = str_replace("'","''",$keyword);
					if($where == '') {
						foreach($fields_arr as $field) {
							if($where == '') {
								$where .= " WHERE sub_property_id = ".$id." AND ".$field." LIKE '%".$keyword."%'".$sql_temp_del;
							} else {
								$where .= " OR sub_property_id = ".$id." AND ".$field." LIKE '%".$keyword."%'".$sql_temp_del;
							}
						}
					} else {
						foreach($fields_arr as $field) {
							$where .= " OR sub_property_id = ".$id." AND ".$field." LIKE '%".$keyword."%'".$sql_temp_del;
						}
					}
				}
			} else {
				if($where == '' && $page != 'system-log') {
					$where = " WHERE sub_property_id = ".$id." AND temp_del = 0";
				} else {
					$where .= $sql_temp_del;
				}
			}
			break;
	}
}
?>