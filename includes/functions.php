<?php
include('support/array-sets.php');
// RENDER
// render language
function renderLang($lang_arr) {
	if(isset($lang_arr[$GLOBALS['default_lang_idx']])) {
		if($lang_arr[$GLOBALS['default_lang_idx']] != '') {
			$return = $lang_arr[$GLOBALS['default_lang_idx']];
		} else {
			$return = $lang_arr[0];
		}
	} else {
		$return = $lang_arr[0];
	}
	return $return;
}
// render error message
function renderError($session) {
	if(isset($_SESSION[$session])) {
		echo '<div class="alert alert-danger"><h5><i class="icon fas fa-ban"></i> '.renderLang($GLOBALS['alert_error']).'</h5>'.$_SESSION[$session].'</div>';
		unset($_SESSION[$session]);
	}
}
// render success message
function renderSuccess($session) {
	if(isset($_SESSION[$session])) {
		echo '<div class="alert alert-success"><h5><i class="icon fas fa-check"></i> '.renderLang($GLOBALS['alert_success']).'</h5>'.$_SESSION[$session].'</div>';
		unset($_SESSION[$session]);
	}
}
// render JS messages in response on delete function
function renderConfirmDelete($err_code,$session_name,$variable_name) {
	switch($err_code) {
		case 0:
			$_SESSION[$session_name] = renderLang($GLOBALS[$variable_name]);;
			echo '1';
			break;
		case 1:
			echo '0,'.renderLang($GLOBALS['modal_session_expired']);
			break;
		case 2:
			echo '0,'.renderLang($GLOBALS['modal_invalid_password']);
			break;
		case 3:
			echo '0,'.renderLang($GLOBALS['modal_unauthorized']);
			break;
		case 4:
			echo '0,'.renderLang($GLOBALS['modal_invalid_id']);
			break;
	}
}
// render status in profile
function renderProfileStatus($status) {
	switch($status) {
		case 0:
			echo '<button class="btn btn-flat btn-success">'.renderLang($GLOBALS['lang_status_active']).'</button>';
			break;
		case 1:
			echo '<button class="btn btn-flat btn-warning">'.renderLang($GLOBALS['lang_status_deactivated']).'</button>';
			break;
		case 2:
			echo '<button class="btn btn-flat btn-danger">'.renderLang($GLOBALS['lang_status_deleted']).'</button>';
			break;
	}
}

// PROCESS
// unset a cookie
function unsetCookie($cookie_name) {
	if(isset($_COOKIE[$cookie_name])) {
		unset($_COOKIE[$cookie_name]);
		setcookie($cookie_name,null,-1,'/');
	}
}
// unset a session
function unsetSession($session) {
	if(isset($_SESSION[$session])) {
		unset($_SESSION[$session]);
	}
	
}
// record action to system log
function systemLog($module,$target_id,$action,$change_log) {
    $user_id = $_SESSION['sys_id'];
    $account_mode = $_SESSION['sys_account_mode'];
	$epoch_time = time();
	$sql = $GLOBALS['pdo']->prepare("INSERT INTO system_log(
		id,
		user_id,
        account_mode,
		module,
		target_id,
		action,
		change_log,
		epoch_time
	) VALUES(
		NULL,
        ".$user_id.",
        '".$account_mode."',
		'".$module."',
		'".$target_id."',
		'".$action."',
		'".$change_log."',
		'".$epoch_time."'
	)");
	$sql->execute();
}

// CHECK VARIABLE OR DATA
function checkVar($variable, $if_array = false) {

    $var_status = 0;


    if($if_array === true) {

        if(isset($variable)) {
            $var_status = 1;
        }

        if(!empty($variable)) {
            $var_status = 1;
        }

    } else {

        if(isset($variable)) {

			$variable = trim($variable);

			if(!empty($variable)) {
				$var_status = 1;
			}
	
			if(strlen($variable) != 0) {
				$var_status = 1;
			}
        }

    }

    return $var_status;

}

// SECURITY
// check session if logged in
function checkSession() {
	$r = 0;
	if(isset($_SESSION['sys_id'])) {
		$r = 1;
	}

	if(!isset($_COOKIE['sys_logged'])) {
		header('location: /logout');
	}

	return $r;

}
// check permission is valid
function checkPermission($permission) {
	$r = 0;
	if(in_array($permission,$_SESSION['sys_permissions'])) {
		$r = 1;
	}
	return $r;
}
// check attachment extension if valid
function checkAttachmentExt($file_name) {
    
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    return in_array($file_ext, $GLOBALS['allowed_attachments_arr']);
}
// check if user account is allowed to view page
function checkAccountMode($page_type, $message) {
    $allowed = 0;
    // app
    if($page_type == "app") {
        if($_SESSION['sys_account_mode'] == 'user' || $_SESSION['sys_account_mode'] == 'employee') {
            // allowed
            $allowed = 1;
        }
    }
    // user portal
    if($page_type == "user_portal") {
        if($_SESSION['sys_account_mode'] == "unit_owner" || $_SESSION['sys_account_mode'] == "tenant") {
            // allowed
            $allowed = 1;
        }
    }

    if($allowed == 0) {
        session_destroy();
        session_start();
        if($page_type == "app") {
            $_SESSION['sys_login_err'] = renderLang($message);
            header('location: /');
            exit();
        }
        if($page_type == "user-portal") {
            $_SESSION['sys_user_login_err'] = renderLang($message);
            header("location: /user-login");
            exit();
        }
    }

}
// encrypt string
function encryptStr($str) {
	$key = $GLOBALS['crypt_key'];
	$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
	$iv = openssl_random_pseudo_bytes($ivlen);
	$ciphertext_raw = openssl_encrypt($str,$cipher,$key,$options=OPENSSL_RAW_DATA,$iv);
	$hmac = hash_hmac('sha256',$ciphertext_raw,$key,$as_binary=true);
	$ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
	return $ciphertext;
}
// decrypt string
function decryptStr($str) {
	$key = $GLOBALS['crypt_key'];
	$c = base64_decode($str);
	$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
	$iv = substr($c,0,$ivlen);
	$hmac = substr($c,$ivlen,$sha2len=32);
	$ciphertext_raw = substr($c,$ivlen+$sha2len);
	$original_plaintext = openssl_decrypt($ciphertext_raw,$cipher,$key,$options=OPENSSL_RAW_DATA,$iv);
	$calcmac = hash_hmac('sha256',$ciphertext_raw,$key,$as_binary=true);
	if (hash_equals($hmac,$calcmac)) { return $original_plaintext; }
}

// GET DATA
function getData($id,$sql_table) {
	$sql = $GLOBALS['pdo']->prepare("SELECT * FROM ".$sql_table." WHERE id = ".$id." LIMIT 1");
	$sql->execute();
	$data = $sql->fetch(PDO::FETCH_ASSOC);
	return $data;
}
// get table data
function getTable($sql_table) {
	$r = array();
	$sql = $GLOBALS['pdo']->prepare("SELECT * FROM ".$sql_table);
	$sql->execute();
	while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
		array_push($r,$data);
	}
	return $r;
}
// get column data
function getField($field, $table, $where) {
	$sql = $GLOBALS['pdo']->prepare("SELECT $field FROM $table WHERE ".$where." LIMIT 1");
	$sql->execute();
	$data = $sql->fetch(PDO::FETCH_ASSOC);

	return $data[$field];

}

// get full name
function getFullName($user_id, $account_mode) {

    $table = '';
    $fields = '';
    $full_name = '';

    switch($account_mode) {
        case 'user':
            $table = 'users';
            $fields = 'firstname, lastname';
        break;

        case 'employee';
            $table = 'employees';
            $fields = 'firstname, lastname, middlename';
        break;
        
        case 'tenant':
            $table = 'tenants';
            $fields = 'firstname, lastname, middlename';
        break;

        case 'unit_owner':
            $table = 'unit_owners';
            $fields = 'firstname, lastname, middlename';
        break;
    }

    if(!empty($fields)) {
      $sql = $GLOBALS['pdo']->prepare("SELECT ".$fields." FROM ".$table." WHERE id = :user_id LIMIT 1");
      $sql->bindParam(":user_id", $user_id);
      $sql->execute();
      $data = $sql->fetch(PDO::FETCH_ASSOC);

      if($account_mode == 'user') {
          switch($_SESSION['sys_language']) {
              case 0:
                  $full_name = $data['firstname'].' '.$data['lastname'];
                  break;
              case 1:
                  $full_name = $data['lastname'].' '.$data['firstname'];
                  break;
          }
      } else {
          switch($_SESSION['sys_language']) {
              case 0:
                  $full_name = $data['firstname'].(!empty($data['middlename']) ? ' '.$data['middlename'].' ': ' ').$data['lastname'];
                  break;
              case 1:
                  $full_name = $data['lastname'].' '.$data['firstname'];
                  break;
          }
      }
      
      return $full_name;
    } else {
        return NULL;
    }

}

// FORMAT
// date
function formatDate($date ,$epoch = false, $word_format = false, $with_time = false) {

    if(!empty($date) || strlen($date) != 0) {

        if($word_format === false) {

            if($epoch) {
                
                if($with_time) {
                    return date('Y-m-d H:i:s', $date);
                } else {
                    return date('Y-m-d', $date);
                }
                
            } else {
                if(strtotime($date)) {
                    if($with_time) {
                        return date('Y-m-d H:i:s', strtotime($date));
                    } else {
                        return date('Y-m-d', strtotime($date));
                    }
                } else {
                    return NULL;
                }
            }

        } else {

            if($epoch) {
                if($with_time) {
                    return date('F j, Y H:i:s', $date);
                } else {
                    return date('F j, Y', $date);
                }
            } else {
                if(strtotime($date)) {
                    if($with_time) {
                        return date('F j, Y H:i:s', strtotime($date));
                    } else {
                        return date('F j, Y', strtotime($date));
                    }
                } else {
                    return NULL;
                }
            }

        }

    } else {
        return NULL;
    }

}

// SITE WIDE FUNCTIONS
// clear sessions of forms
function clearSessions() {
	
	$process_arr = array('add','edit');
	$data_type_arr = array('val','err');
	
	// SETTINGS
	unsetSession('sys_settings_tab_selected');
	
	// CLIENT
	$module = 'clients';
	$fields_arr = array(
		'client',
		'client_id',
		'status',
		'client_name',
		'contact_person',
		'contact_details'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);
	
	// UNIT OWNERS
	$module = 'unit_owners';
	$fields_arr = array(
		'unit_owner',
		'unit_owner_id',
		'status',
		'firstname',
		'middlename',
		'lastname',
		'gender'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);
	
	// TENANT
	$module = 'tenants';
	$fields_arr = array(
		'tenant',
		'tenant_id',
		'status',
		'firstname',
		'middlename',
		'lastname',
		'gender',
		'citizenship_id',
		'relationship_to_owner',
		'social_status'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// OCCUPANTS
	$module = 'occupants';
	$fields_arr = array(
		'occupant',
		'unit_id',
		'status',
		'firstname',
		'middlename',
		'lastname',
		'gender',
		'birthdate',
		'civil_status',
		'citizenship_id',
		'relationship_to_tenant',
		'social_status'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// DEPARTMENTS
	$module = 'departments';
	$fields_arr = array(
		'department',
		'department_code',
		'department_name'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);
	
	// EMPLOYEES
	$module = 'employees';
	$fields_arr = array(
		'employee',
		'employee_id',
		'department_id',
		'sub_property_ids',
		'status',
		'firstname',
		'middlename',
		'lastname',
		'gender',
    'roles',
    'code_name'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);
	
	// USERS
	$module = 'users';
	$fields_arr = array(
		'user',
		'uname',
		'status',
		'firstname',
		'middlename',
		'lastname',
		'gender',
		'roles'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// ROLES
	$module = 'roles';
	$fields_arr = array(
    'role',
    'role_role_name',
		'role_code',
		'role_permissions'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// PROPERTIES
	$module = 'properties';
	$fields_arr = array(
		'property',
		'property_code',
		'property_name',
		'client_id',
    'status',
    'property_id'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);
	
	// SUB PROPERTIES
	$module = 'sub_properties';
	$fields_arr = array(
		'sub_property',
		'sub_property_code',
		'sub_property_name',
		'status'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// UNITS
	$module = 'units';
	$fields_arr = array(
		'unit',
		'unit_name',
		'unit_type',
		'unit_area',
		'vacancy_status',
		'unit_owner_id',
		'vacancy_type',
		'unit_capacity',
		'commercial_unit_type_id'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// TASK -> WORK ORDER
	$module = 'work-order';
	$fields_arr = array(
		'work-order',
		'work_order_no',
		'date',
		'assigned',
		'work_order_nature',
		'work_order_nature_specify',
		'unit',
		'requested_by'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// TASK -> JOB ORDER
	$module = 'job-order';
	$fields_arr = array(
		'job_order_no',
		'date',
		'assigned',
		'job_order_nature',
		'job_order_nature_specify',
		'description',
		'unit',
		'requested_by'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);


	// TASK -> JOB ORDER
	$module = 'prospecting';
	$fields_arr = array(
		'reference_number',
		'project_name',
		'owner_developer',
		'location',
		'property_category',
		'property_category_others',
		'number_of_building',
		'property_age',
		'service_required',
		'other_services',
		'current_property_management',
		'other_remarks',
		'contact_person',
		'designation',
		'telephone',
		'mobile_number',
		'email_address',
		'remarks_on_contact_person',
		'referred_by',
		'lead_received_through',
		'other_lead_remarks',
		'date'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);
	
	// CONTRACT
	$module = 'contract';
	$fields_arr = array(
		'prospect_id',
		'acquisition_date',
		'renewal_date',
		'contract_contact_person',
		'contact_number',
		'status'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);
	
	// MOVE IN/OUT REQUESTS
	$module = 'move_inout_requests';
	$fields_arr = array(
		'request',
		'date',
		'item_no',
		'description',
		'quantity',
		'unit',
		'remarks',
		'status'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// SERVICE PROVIDERS
	$module = 'service_providers';
	$fields_arr = array(
		'name_of_the_company',
		'services',
		'contact_person',
		'mobile_number',
		'landline_number',
		'email_address'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);
	
	// VISITORS
	$module = 'visitors';
	$fields_arr = array(
		'time_in',
		'time_out',
		'contact_person',
		'name_of_visitor',
		'company_address',
		'person_to_visit',
		'purpose',
		'status'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// SERVICE REQUEST
	$module = 'service_requests';
	$fields_arr = array(
		'date',
		'comaplainant',
		'unit_no',
		'service',
		'description',
		'assessment',
		'remarks',
		'status'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// GATE PASS EMPLOYEE
	$module = 'gate_pass_employees';
	$fields_arr = array(
		'date',
		'employee_name',
		'purpose',
		'time_in',
		'time_out'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// AMENITIES
	$module = 'amenities';
	$fields_arr = array(
		'date',
		'venue',
		'subject',
		'property_name',
		'time_started_end',
		'status'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

	// BOARDROOMS
	$module = 'boardrooms';
	$fields_arr = array(
		'time',
		'department',
		'purpose',
		'reserved_by',
		'status'
	);
	unsetSessions($module,$fields_arr,$process_arr,$data_type_arr);

}

// set unset all sessions in fields arr
function unsetSessions($module,$fields_arr,$process_arr,$data_type_arr) {
	foreach($fields_arr as $field) {
		foreach($process_arr as $process) {
			foreach($data_type_arr as $data_type) {
				unsetSession('sys_'.$module.'_'.$process.'_'.$field.'_'.$data_type);
			}
		}
	}
}

// push notifications
function push_notification($module, $module_id, $user_id, $account_mode, $notification){

    $date = time();
    $source_id = $_SESSION['sys_id'];
    $source_account_mode = $_SESSION['sys_account_mode'];

    $sql = $GLOBALS['pdo']->prepare("INSERT INTO notifications (
        notification, 
        source_id, 
        source_account_mode, 
        module, 
        module_id, 
        date, 
        user_id, 
        account_mode
    ) VALUES (
        :notification,
        :source_id,
        :source_account_mode,
        :module, 
        :module_id, 
        :date,
        :user_id, 
        :account_mode
    )");

    $sql->bindParam(":notification", $notification);
    $sql->bindParam(":source_id", $source_id);
    $sql->bindParam(":source_account_mode", $source_account_mode);
    $sql->bindParam(":module", $module);
    $sql->bindParam(":module_id", $module_id);
    $sql->bindParam(":date", $date);
    $sql->bindParam(":user_id", $user_id);
    $sql->bindParam(":account_mode", $account_mode);
    $sql->execute();

    $id = $GLOBALS['pdo']->lastInsertId();

    $new_notif = array(
        "id" => $id,
        "notification" => $notification,
        "source_id" => $source_id,
        "source_account_mode" => $source_account_mode,
        "module" => $module,
        "module_id" => $module_id,
        "date" => $date,
        "user_id" => $user_id,
        "account_mode" => $account_mode,
        "status" => null
    );

    $cache_file = $_SERVER['DOCUMENT_ROOT'].'/caches/notifications.json';
    if(file_exists($cache_file)) {

        $fetch = file_get_contents($cache_file);
        $datas = json_decode($fetch, true);
        array_push($datas, $new_notif);
        $datas = json_encode($datas);
        file_put_contents($cache_file, $datas);

    } else {
        $query = "SELECT * FROM notifications ORDER BY id DESC";
        updateCache('notifications.json', $query);
    }

}

// GET EMPLOYEE USER INFO ==============

// get user cluster
function getClusterIDs($user_id) {

	$cluster_ids = array();

	// check if user have cluster
	$sql = $GLOBALS['pdo']->prepare("SELECT id FROM clusters WHERE assigned = :sys_id");
	$sql->bindParam(":sys_id", $user_id);
	$sql->execute();

	while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
		$cluster_ids[] = $data['id'];
	}

	return $cluster_ids;

}

// get user assigned properties
function getClusterProperties($cluster_id) {

	$property_ids = array();

	// get all properties under cluster
	$sql = $GLOBALS['pdo']->prepare("SELECT id FROM properties WHERE temp_del = 0 AND cluster_id = :cluster_id");
	$sql->bindParam(":cluster_id", $cluster_id);
	$sql->execute();
	if($sql->rowCount()) {
		while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
			$property_ids[] = $data['id'];
		}
	}

	return $property_ids;
}

// render attachments
function renderAttachments($attachment_data, $folder, $height = '29px', $width = '29px') {

    if(!empty($attachment_data)) {

        $img_ext = array('jpg', 'jpeg', 'png');
        if(strpos($attachment_data, ',')) {

            $attachments = explode(',', $attachment_data);
            foreach($attachments as $attachment) {

                $attachment_part = explode('.', $attachment);
                $extension = $attachment_part[1];
                if(in_array(strtolower($extension), $img_ext)) {

                    
                        echo '<a href="/assets/uploads/'.$folder.'/'.$attachment.'" data-toggle="lightbox">'; 
                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/'.$folder.'/'.$attachment.'" style="height: '.$height.'; width: '.$width.';" class="mr-1"></img>';
                            echo $attachment;
                        echo '</a><br>';
                    

                } else {

                    echo '<a href="/assets/uploads/'.$folder.'/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                }

            }

        } else {

            $attachment_part = explode('.', $attachment_data);
            $extension = $attachment_part[1];
            if(in_array(strtolower($extension), $img_ext)) {

                    
                echo '<a href="/assets/uploads/'.$folder.'/'.$attachment_data.'" data-toggle="lightbox">'; 
                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/'.$folder.'/'.$attachment_data.'" style="height: '.$height.'; width: '.$width.';" class="mr-1"></img>';
                    echo $attachment_data;
                echo '</a><br>';
                

            } else {

                echo '<a href="/assets/uploads/'.$folder.'/'.$attachment_data.'" target="_blank">'.$attachment_data.'</a><br>';

            }
        
        }

    }
}

// get sub property cluster
function getSubPropertyCluster($sub_property_id) {

    $sub_property_id = trim($sub_property_id);
    $property_id = getField('property_id', 'sub_properties', 'id = '.$sub_property_id);
    $cluster_id = getField('cluster_id', 'properties', 'id = '.$property_id);

    return $cluster_id;
}

// PAGINATION
// get total page number
function get_total_page_number($total_row, $qry_limit) {
    return ceil($total_row/$qry_limit);
}
// get query start
function get_qry_start($qry_limit, $page) {
    return ((int)$qry_limit*(int)$page)-(int)($qry_limit);
}

// CLUSTERING
function get_user_cluster_data($user_id) {

    // get clusters of user
    $cluster_ids = getClusterIDs($_SESSION['sys_id']);

    // no cluster
    if(empty($cluster_ids)) {

        $sub_properties = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
        $sub_property_ids = explode(',', $sub_properties);
        $properties = getField('property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
        $property_ids = explode(',', $properties);

    } else { // has cluster

        // get all properties under cluster
        $property_ids = array();
        $sub_property_ids = array();
        foreach($cluster_ids as $cluster_id) {
            // get properties under cluster
            $property_ids = getClusterProperties($cluster_id);

            // get all sub_properties under property
            foreach($property_ids as $property_id) {
                $sql = $GLOBALS['pdo']->prepare("SELECT id FROM sub_properties WHERE property_id = :property_id AND temp_del = 0");
                $sql->bindParam(":property_id", $property_id);
                $sql->execute();
                if($sql->rowCount()) {
                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $sub_property_ids[] = $data['id'];
                    }
                }
            }
        }

    }

    $property_ids = array_filter($property_ids);
    $sub_property_ids = array_filter($sub_property_ids);

    return array(
        'properties' => $property_ids,
        'sub_properties' => $sub_property_ids
    );

}

// PUSH REMINDERS
function pushReminder($components) {

    $target_id = $components['target_id']; 
    $module = $components['module'];
    $reminder_date = $components['reminder_date']; 
    $user_id = $components['user_id']; 
    $account_mode = $components['account_mode'];
    $message = $components['message'];

    $sql = $GLOBALS['pdo']->prepare("INSERT INTO reminders (
        reminder_msg, 
        target_id, 
        module, 
        reminder_date, 
        user_id, 
        user_account_mode
    ) VALUES (
        :reminder_msg, 
        :target_id, 
        :module, 
        :reminder_date, 
        :user_id, 
        :account_mode
    )");
    $sql->bindParam(":reminder_msg", $message);
    $sql->bindParam(":target_id", $target_id);
    $sql->bindParam(":module", $module);
    $sql->bindParam(":reminder_date", $reminder_date);
    $sql->bindParam(":user_id", $user_id);
    $sql->bindParam(":account_mode", $account_mode);
    $sql->execute();

}

// RENDER REMINDER
function renderReminder($reminder_code = "") {
    if(isset($_SESSION['sys_reminders'][$reminder_code])) {
        foreach($_SESSION['sys_reminders'][$reminder_code] as $reminders) {
            $reminders['code'] = $reminder_code;
            $_SESSION['sys_reminder_code'][$reminders['module']][] = $reminders;
        }
    }
}

// RENDER COMMENTS
function renderComments($module_id, $module, $type, $permission_to_add, $title) {
    $sql = $GLOBALS['pdo']->prepare("SELECT * FROM comments WHERE module = :module AND module_type = :type AND module_id = :id AND temp_del = 0 ORDER BY comment_date DESC");
    $sql->bindParam(":module", $module);
    $sql->bindParam(":type", $type);
    $sql->bindParam(":id", $module_id);
    $sql->execute();

    echo '<div class="card card-primary direct-chat direct-chat-primary">';
        echo '<div class="card-header">';
            echo '<h3 class="card-title">'.$title.'</h3>';
        echo '</div>';
        echo '<div class="card-body">';
            echo '<div class="direct-chat-messages">';

                if($sql->rowCount()) {
                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                        
                        if($_SESSION['sys_id'] == $data['user_id'] && $_SESSION['sys_account_mode'] == $data['user_account_mode']) {

                            echo '<div class="direct-chat-msg right">';
                                echo '<div class="direct-chat-info clearfix">';

                                    echo '<span class="direct-chat-name float-right">'.getFullName($data['user_id'], $data['user_account_mode']).'</span>';
                                    echo '<span class="direct-chat-timestamp float-left">'.formatDate($data['comment_date'], true, false, true).'</span>';

                                    echo '</div>';

                                    echo '<img class="direct-chat-img bg-dark" src="'.$_SESSION['sys_photo'].'" alt="message user image">';

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

                                    echo '<img class="direct-chat-img bg-dark" src="'.(!empty($photo) ? $photo : '/dist/img/avatar2.png').'" alt="message user image">';

                                    echo '<div class="direct-chat-text">';
                                        echo $data['comment'];
                                    echo '</div>';
                            echo '</div>';

                        }
                            
                    }
                } else {
                    echo 'No Comment Yet.';
                }

            echo '</div>';
        echo '</div>';
        echo '<div class="card-footer">';
            if(checkPermission($permission_to_add)) {
                echo '<div class="input-group">';
                    echo '<input type="text" name="comment" placeholder="" class="form-control comment-input" id="comment-input">';
                    echo '<span class="input-group-append">';
                        echo '<button type="button" id="add-comment" class="btn btn-primary">Send</button>';
                    echo '</span>';
                echo '</div>';
                echo '<p id="err_msg" class="error-message text-danger mt-1"></p>';
            }
        echo '</div>';
    echo '</div>';
}

// UPDATE CACHE
function updateCache($file_name, $query) {

    // create directory
    if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/caches')) {
        mkdir($_SERVER['DOCUMENT_ROOT'].'/caches', 0755, true);
    }

    $cache = $_SERVER['DOCUMENT_ROOT'].'/caches/'.$file_name;
    $fh = fopen($cache, 'w') or die ("Error"); // create file

    // get all count sheet data
    $sql = $GLOBALS['pdo']->prepare($query);
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    fwrite($fh, json_encode($data)); // write data in file
    fclose($fh); // close file
}
?>