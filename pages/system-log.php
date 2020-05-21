<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// clear sessions from forms
	clearSessions();
	
	// set page
	$page = 'system-log';
	
	// set fields from table to search on
	$fields_arr = array('user_id', 'FROM_UNIXTIME(epoch_time)');
	$search_placeholder = 'User Name, Date';
	require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');

	$sql_query = 'SELECT * FROM system_log'.$where; // set sql statement
    require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
	$roles_arr = getTable('roles');
	$departments_arr = getTable('departments');
	$unit_owners_arr = getTable('unit_owners');
	$properties_arr = getTable('properties');
	$sub_properties_arr = getTable('sub_properties');
	$commercial_unit_types_arr = getTable('commercial_unit_types');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($system_log_title); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/system-log.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	
	<!-- WRAPPER -->
	<div class="wrapper">
		
		<?php
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/sidebar.php');
		?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			
			<!-- CONTENT HEADER -->
			<section class="content-header">
				<div class="container-fluid">
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fa fa-align-left mr-3"></i><?php echo renderLang($system_log_title); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>

					<div class="card">
						<div class="card-body">

							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-and-pagination.php'); ?>
							
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th style="width:150px;"><?php echo renderLang($system_log_user); ?></th>
											<th style="width:100px;"><?php echo renderLang($system_log_module); ?></th>
											<th style="width:100px;"><?php echo renderLang($system_log_action); ?></th>
											<th style="width:200px;"><?php echo renderLang($system_log_target); ?></th>
											<th><?php echo renderLang($system_log_change_log); ?></th>
											<th style="width:100px;"><?php echo renderLang($system_log_time_stamp); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT * FROM system_log".$where." ORDER BY id DESC LIMIT ".$sql_start.",".$numrows);
										$sql->execute();
	
										if($sql->rowCount() == 0) {
											echo '<tr><td colspan="6">'.renderLang($lang_no_data_display).'</td></tr>';
										} else {

											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

												$data_count++;

                                                echo '<tr>';
                                                
													// USER ID
                                                    echo '<td>';
                                                    if(checkVar($data['account_mode'])) {
                                                        if($data['account_mode'] == "user") {
                                                            echo getFullName($data['user_id'], 'user');
                                                        } else { // employees
                                                            echo '<a href="/user/'.$data['user_id'].'">';
                                                                echo getFullName($data['user_id'], 'employee');
                                                            echo '</a>';
                                                        }
                                                    } else {
                                                        echo '<a href="/user/'.$data['user_id'].'">';
                                                            echo getFullName($data['user_id'], 'employee');
                                                        echo '</a>';
                                                    }
													echo '</td>';

													// MODULE
													echo '<td>'.renderLang(${"module_".$data['module']}).'</td>';

													// ACTION
													echo '<td>'.renderLang(${"system_log_".$data['action']}).'</td>';

													// TARGET ID
													echo '<td>';
														switch($data['module']) {

															case 'role':
																$_data = getData($data['target_id'],'roles');
																echo '<a href="/role/'.$_data['id'].'">'.$_data['role_name'].'</a>';
																break;

															case 'user':
																$_data = getData($data['target_id'],'users');
																echo '<a href="/user/'.$_data['id'].'">';
																	switch($_SESSION['sys_language']) {
																		case 0:
																			echo '['.$_data['uname'].']<br>'.$_data['firstname'].' '.$_data['lastname'];
																			break;
																		case 1:
																			echo '['.$_data['uname'].']<br>'.$_data['lastname'].' '.$_data['firstname'];
																			break;
																	}
																echo '</a>';
																break;

															case 'client':
																$_data = getData($data['target_id'],'clients');
																echo '<a href="/client/'.$_data['id'].'">['.$_data['client_id'].']<br>'.$_data['client_name'].'</a>';
																break;

															case 'unit_owner':
																$_data = getData($data['target_id'],'unit_owners');
																echo '<a href="/unit-owner/'.$_data['id'].'">';
																	switch($_SESSION['sys_language']) {
																		case 0:
																			echo '['.$_data['unit_owner_id'].']<br>'.$_data['firstname'].' '.$_data['lastname'];
																			break;
																		case 1:
																			echo '['.$_data['unit_owner_id'].']<br>'.$_data['lastname'].' '.$_data['firstname'];
																			break;
																	}
																echo '</a>';
																break;

															case 'tenant':
																$_data = getData($data['target_id'],'tenants');
																echo '<a href="/tenant/'.$_data['id'].'">';
																	switch($_SESSION['sys_language']) {
																		case 0:
																			echo '['.$_data['tenant_id'].']<br>'.$_data['firstname'].' '.$_data['lastname'];
																			break;
																		case 1:
																			echo '['.$_data['tenant_id'].']<br>'.$_data['lastname'].' '.$_data['firstname'];
																			break;
																	}
																echo '</a>';
																break;

															case 'employee':
																$_data = getData($data['target_id'],'employees');
																echo '<a href="/employee/'.$_data['id'].'">';
																	switch($_SESSION['sys_language']) {
																		case 0:
																			echo '['.$_data['employee_id'].']<br>'.$_data['firstname'].' '.$_data['lastname'];
																			break;
																		case 1:
																			echo '['.$_data['employee_id'].']<br>'.$_data['lastname'].' '.$_data['firstname'];
																			break;
																	}
																echo '</a>';
																break;

															case 'department':
																$_data = getData($data['target_id'],'departments');
																echo '<a href="/department/'.$_data['id'].'">['.$_data['department_code'].']<br>'.$_data['department_name'].'</a>';
																break;

															case 'property':
																$_data = getData($data['target_id'],'properties');
																echo '<a href="/property/'.$_data['id'].'">['.$_data['property_code'].']<br>'.$_data['property_name'].'</a>';
																break;

															case 'sub_property':
																$_data = getData($data['target_id'],'sub_properties');
																$_data2 = getData($_data['property_id'],'properties');
																echo '<a href="/sub-property/'.$_data['id'].'">['.$_data2['property_code'].'] '.$_data['sub_property_name'].'</a>';
																break;

															case 'unit':
																$_data = getData($data['target_id'],'units');
																echo '<a href="/unit/'.$_data['id'].'">';
																	echo $_data['unit_name'].' ';
																	foreach($sub_properties_arr as $sub_property) {
																		if($sub_property['id'] == $_data['sub_property_id']) {
																			echo $sub_property['sub_property_name'];
																		}
																	}
																	foreach($properties_arr as $property) {
																		if($property['id'] == $_data['property_id']) {
																			echo '<br>'.$property['property_name'];
																		}
																	}
																echo '</a>';
                                                                break;
                                                                
                                                            case 'prospecting':
                                                                $_data = getData($data['target_id'], 'prospecting');
                                                                echo '<a href="/edit-prospecting/'.$_data['id'].'">['.$_data['reference_number'].'] '.$_data['project_name'].'</a>';
                                                                break;

                                                            case 'prospecting_activity':
                                                                $_data = getData($data['target_id'], 'prospecting');
                                                                echo '<a href="/prospect-activities/'.$_data['id'].'">['.$_data['reference_number'].'] '.$_data['project_name'].'</a>';
                                                                break;

                                                            case 'labor_cost':
                                                                $_data = getData($data['target_id'], 'labor_cost');
                                                                echo '<a href="/labor-cost/'.$_data['id'].'">'.getField('project_name', 'prospecting', 'id = '.$_data['prospect_id']).'</a>';
                                                                break;

                                                            case 'notice_to_proceed':
                                                                $_data = getData($data['target_id'], 'notice_to_proceed');
                                                                echo '<a href="/notice-to-proceed/'.$_data['id'].'">'.getField('project_name', 'prospecting', 'id = '.$_data['prospect_id']).'</a>';
                                                                break;

                                                            case 'nni':
                                                                $_data = getData($data['target_id'], 'nni');
                                                                echo '<a href="/edit-nni/'.$_data['prospect_id'].'">'.getField('project_name', 'prospecting', 'id = '.$_data['prospect_id']).'</a>';
                                                                break;

														}
													echo '</td>';

													// CHANGE LOG
													echo '<td>';

														// if ACTION is UPDATE
														if($data['action'] == 'update') {

															$change_log_arr = explode(';;',$data['change_log']);
															foreach($change_log_arr as $change_log) {

																$item_arr = explode('::',$change_log);
																$changes_arr = explode('==',$item_arr[1]);
																$field_name = $item_arr[0];
																$from_val = $changes_arr[0];
																$to_val = $changes_arr[1];

																// render permissions for roles
																if($field_name == 'lang_permissions') {

																	$from_val_arr = explode(',',$from_val);
																	foreach($from_val_arr as $i => $from_val) {
																		foreach($permissions_arr as $permission_group) {
																			foreach($permission_group as $permission) {
																				if($permission['permission_code'] == $from_val) {
																					$from_val_arr[$i] = renderLang($permission['permission_name']);
																					break;
																				}
																			}
																		}
																	}
																	$from_val = implode($from_val_arr,', ');

																	$to_val_arr = explode(',',$to_val);
																	foreach($to_val_arr as $i => $to_val) {
																		foreach($permissions_arr as $permission_group) {
																			foreach($permission_group as $permission) {
																				if($permission['permission_code'] == $to_val) {
																					$to_val_arr[$i] = renderLang($permission['permission_name']);
																					break;
																				}
																			}
																		}
																	}
																	$to_val = implode($to_val_arr,', ');

																}

																// render role name
																if($field_name == 'roles_roles') {

																	$from_val_arr = explode(',',$from_val);
																	foreach($from_val_arr as $i => $from_val) {
																		if($from_val == '') {
																			unset($from_val_arr[$i]);
																		} else {
																			foreach($roles_arr as $role) {
																				if($from_val == $role['id']) {
																					$from_val_arr[$i] = $role['role_name'];
																					break;
																				}
																			}
																		}
																	}
																	$from_val = implode($from_val_arr,', ');

																	$to_val_arr = explode(',',$to_val);
																	foreach($to_val_arr as $i => $to_val) {
																		if($to_val == '') {
																			unset($to_val_arr[$i]);
																		} else {
																			foreach($roles_arr as $role) {
																				if($to_val == $role['id']) {
																					$to_val_arr[$i] = $role['role_name'];
																					break;
																				}
																			}
																		}
																	}
																	$to_val = implode($to_val_arr,', ');

																}

																// department name
																if($field_name == 'departments_department') {

																	if($from_val == 0) {
																		$from_val = 'TBD';
																	} else {
																		foreach($departments_arr as $department) {
																			if($from_val == $department['id']) {
																				$from_val = $department['department_name'];
																				break;
																			}
																		}
																	}

																	if($to_val == 0) {
																		$to_val = 'TBD';
																	} else {
																		foreach($departments_arr as $department) {
																			if($to_val == $department['id']) {
																				$to_val = $department['department_name'];
																				break;
																			}
																		}
																	}

																}

																// property name
																if($field_name == 'properties_properties') {
																	
																	if($from_val == ',') {
																		$from_val = 'TBD';
																	} else {
																		$from_val_display = array();
																		$from_val_arr = explode(',',$from_val);
																		foreach($sub_properties_arr as $sub_property) {
																			foreach($from_val_arr as $from_val__) {
																				if($from_val__ == $sub_property['id']) {
																					$property_name = '';
																					foreach($properties_arr as $property) {
																						if($sub_property['property_id'] == $property['id']) {
																							$property_name = '['.$property['property_code'].'] ';
																							break;
																						}
																					}
																					array_push($from_val_display,'<a href="/sub-property/'.$sub_property['id'].'">'.$property_name.$sub_property['sub_property_name'].'</a>');
																					break;
																				}
																			}
																		}
																		$from_val = implode($from_val_display,', ');
																	}

																	if($to_val == ',') {
																		$to_val = 'TBD';
																	} else {
																		$to_val_display = array();
																		$to_val_arr = explode(',',$to_val);
																		foreach($sub_properties_arr as $sub_property) {
																			foreach($to_val_arr as $to_val__) {
																				if($to_val__ == $sub_property['id']) {
																					$property_name = '';
																					foreach($properties_arr as $property) {
																						if($sub_property['property_id'] == $property['id']) {
																							$property_name = '['.$property['property_code'].'] ';
																							break;
																						}
																					}
																					array_push($to_val_display,'<a href="/sub-property/'.$sub_property['id'].'">'.$property_name.$sub_property['sub_property_name'].'</a>');
																					break;
																				}
																			}
																		}
																		$to_val = implode($to_val_display,', ');
																	}

																}

																// render status
																if($field_name == 'lang_status') {

																	foreach($status_arr as $status) {
																		if($status[0] == $from_val) {
																			$from_val = renderLang($status[1]);
																			break;
																		}
																	}

																	foreach($status_arr as $status) {
																		if($status[0] == $to_val) {
																			$to_val = renderLang($status[1]);
																			break;
																		}
																	}

                                                                }

																// render gender
																if(
																	$field_name == 'employees_gender' ||
																	$field_name == 'tenants_gender' ||
																	$field_name == 'unit_owners_gender'
																) {

																	foreach($gender_arr as $gender) {
																		if($gender[0] == $from_val) {
																			$from_val = renderLang($gender[1]);
																			break;
																		}
																	}

																	foreach($gender_arr as $gender) {
																		if($gender[0] == $to_val) {
																			$to_val = renderLang($gender[1]);
																			break;
																		}
																	}

																}

																// render civil status
																if(
																	$field_name == 'unit_owners_civil_status'
																) {

																	foreach($civil_status_arr as $civil_status) {
																		if($civil_status[0] == $from_val) {
																			$from_val = renderLang($civil_status[1]);
																			break;
																		}
																	}

																	foreach($civil_status_arr as $civil_status) {
																		if($civil_status[0] == $to_val) {
																			$to_val = renderLang($civil_status[1]);
																			break;
																		}
																	}

																}

																// department name
																if($field_name == 'unit_owners_unit_owner') {

																	if($from_val == 0) {
																		$from_val = 'TBD';
																	} else {
																		foreach($unit_owners_arr as $unit_owner) {
																			if($from_val == $unit_owner['id']) {
																				switch($_SESSION['sys_language']) {
																					case 0:
																						$from_val = '<a href="/unit-owner/'.$unit_owner['id'].'">['.$unit_owner['unit_owner_id'].'] '.$unit_owner['firstname'].' '.$unit_owner['lastname'].'</a>';
																						break;
																					case 1:
																						$from_val = '<a href="/unit-owner/'.$unit_owner['id'].'">['.$unit_owner['unit_owner_id'].'] '.$unit_owner['lastname'].' '.$unit_owner['firstname'].'</a>';
																						break;
																				}
																				break;
																			}
																		}
																	}

																	if($to_val == 0) {
																		$to_val = 'TBD';
																	} else {
																		foreach($unit_owners_arr as $unit_owner) {
																			if($to_val == $unit_owner['id']) {
																				switch($_SESSION['sys_language']) {
																					case 0:
																						$to_val = '<a href="/unit-owner/'.$unit_owner['id'].'">['.$unit_owner['unit_owner_id'].'] '.$unit_owner['firstname'].' '.$unit_owner['lastname'].'</a>';
																						break;
																					case 1:
																						$to_val = '<a href="/unit-owner/'.$unit_owner['id'].'">['.$unit_owner['unit_owner_id'].'] '.$unit_owner['lastname'].' '.$unit_owner['firstname'].'</a>';
																						break;
																				}
																				break;
																			}
																		}
																	}

																}

																// vacancy type
																if($field_name == 'units_type') {

																	foreach($vacancy_type_arr as $vacancy_type) {
																		if($vacancy_type[0] == $from_val) {
																			$from_val = renderLang($vacancy_type[1]);
																			break;
																		}
																	}

																	foreach($vacancy_type_arr as $vacancy_type) {
																		if($vacancy_type[0] == $to_val) {
																			$to_val = renderLang($vacancy_type[1]);
																			break;
																		}
																	}

																}

																// vacancy type
																if($field_name == 'units_vacant') {

																	foreach($yesno_arr as $yesno) {
																		if($yesno[0] == $from_val) {
																			$from_val = renderLang($yesno[1]);
																			break;
																		}
																	}

																	foreach($yesno_arr as $yesno) {
																		if($yesno[0] == $to_val) {
																			$to_val = renderLang($yesno[1]);
																			break;
																		}
																	}

																}

																// commercial type
																if($field_name == 'units_commercial_type') {

																	if($from_val == 0) {
																		$from_val = 'TBD';
																	} else {
																		foreach($commercial_unit_types_arr as $commercial_unit_type) {
																			if($from_val == $commercial_unit_type['id']) {
																				$from_val = $commercial_unit_type['commercial_unit_type'];
																				break;
																			}
																		}
																	}

																	if($to_val == 0) {
																		$to_val = 'TBD';
																	} else {
																		foreach($commercial_unit_types_arr as $commercial_unit_type) {
																			if($to_val == $commercial_unit_type['id']) {
																				$to_val = $commercial_unit_type['commercial_unit_type'];
																				break;
																			}
																		}
																	}

																}
																
																// render calibration status
																if($field_name == 'calibration_status') {

																	foreach($daily_collection_report_status_arr as $key => $status) {
																		if($key == $from_val) {
																			$from_val = renderLang($status);
																			break;
																		}
																	}

																	foreach($daily_collection_report_status_arr as $key => $status) {
																		if($key == $to_val) {
																			$to_val = renderLang($status);
																			break;
																		}
																	}

																}
																
																// render undeposited status
																if($field_name == 'undeposited_status') {

																	foreach($on_hand_collection_status_arr as $key => $status) {
																		if($key == $from_val) {
																			$from_val = renderLang($status);
																			break;
																		}
																	}

																	foreach($on_hand_collection_status_arr as $key => $status) {
																		if($key == $to_val) {
																			$to_val = renderLang($status);
																			break;
																		}
																	}

                                                                }
                                                                
                                                                // property category
                                                                if($field_name == 'prospecting_property_category') {

                                                                    foreach($prospecting_property_category_arr as $key => $property_category) {
                                                                        if($key == $from_val) {
                                                                            $from_val = renderLang($property_category);
                                                                        }
                                                                    }

                                                                    foreach($prospecting_property_category_arr as $key => $property_category) {
                                                                        if($key == $to_val) {
                                                                            $to_val = renderLang($property_category);
                                                                        }
                                                                    }
                                                                }

                                                                // number of Building
                                                                if($field_name == 'prospecting_number_of_building') {

                                                                    foreach($prospecting_number_of_building_arr as $key => $number_of_building) {
                                                                        if($key == $from_val) {
                                                                            $from_val = renderLang($number_of_building);
                                                                        }
                                                                    }

                                                                    foreach($prospecting_number_of_building_arr as $key => $number_of_building) {
                                                                        if($key == $to_val) {
                                                                            $to_val = renderLang($number_of_building);
                                                                        }
                                                                    }

                                                                }

                                                                // service required
                                                                if($field_name == 'prospecting_service_required') {

                                                                    foreach($prospecting_service_required_arr as $key => $service_required) {
                                                                        if($key == $from_val) {
                                                                            $from_val = renderLang($service_required);
                                                                        }
                                                                    }

                                                                    foreach($prospecting_service_required_arr as $key => $service_required) {
                                                                        if($key == $to_val) {
                                                                            $to_val = renderLang($service_required);
                                                                        }
                                                                    }

                                                                }

                                                                // lead receive through
                                                                if($field_name == 'prospecting_lead_received_through') {

                                                                    foreach($prospecting_lead_received_through_arr as $key => $receive_through) {
                                                                        if($key == $from_val) {
                                                                            $from_val = renderLang($receive_through);
                                                                        }
                                                                    }

                                                                    foreach($prospecting_lead_received_through_arr as $key => $receive_through) {
                                                                        if($key == $to_val) {
                                                                            $to_val = renderLang($receive_through);
                                                                        }
                                                                    }

                                                                }

                                                                // prospecting status
                                                                if($field_name == 'prospecting_status') {

                                                                    foreach($prospect_status_arr as $key => $status) {
                                                                        if($key == $from_val) {
                                                                            $from_val = renderLang($status);
                                                                        }
                                                                    }

                                                                    foreach($prospect_status_arr as $key => $status) {
                                                                        if($key == $to_val) {
                                                                            $to_val = renderLang($status);
                                                                        }
                                                                    }

                                                                }

                                                                // labor cost position
                                                                if($field_name == 'labor_cost_position') {

                                                                    $from_val = getField('position', 'positions_for_project', 'id = '.$from_val);

                                                                    $to_val = getField('position', 'positions_for_project', 'id = '.$to_val);

                                                                }

                                                                // proposal status
                                                                if($field_name == 'proposal_status') {

                                                                    foreach($labor_cost_status_arr as $key => $status) {
                                                                        if($key == $from_val) {
                                                                            $from_val = renderLang($status);
                                                                        }
                                                                    }

                                                                    foreach($labor_cost_status_arr as $key => $status) {
                                                                        if($key == $to_val) {
                                                                            $to_val = renderLang($status);
                                                                        }
                                                                    }

                                                                }

                                                                // lc night duty
                                                                if($field_name == 'labor_cost_for_night_duty') {

                                                                    foreach($yesno_arr as $yesno) {
                                                                        if($yesno[0] == $from_val) {
                                                                            $from_val = renderLang($yesno[1]);
                                                                        }
                                                                    }

                                                                    foreach($yesno_arr as $yesno) {
                                                                        if($yesno[0] == $to_val) {
                                                                            $to_val = renderLang($yesno[1]);
                                                                        }
                                                                    }

                                                                }

                                                                // NTP status
                                                                if($field_name == 'notice_to_proceed_status') {

                                                                    foreach($notice_to_proceed_status_arr as $key => $status) {
                                                                        if($key == $from_val) {
                                                                            $from_val = renderLang($status);
                                                                        }
                                                                    }

                                                                    foreach($notice_to_proceed_status_arr as $key => $status) {
                                                                        if($key == $to_val) {
                                                                            $to_val = renderLang($status);
                                                                        }
                                                                    }

                                                                }
																
																switch($_SESSION['sys_language']) {
																	case 0:
																		echo '<em>'.renderLang(${$field_name}).'</em> from <strong>'.$from_val.'</strong> to <strong>'.$to_val.'</strong><br>';
																		break;
																	case 1:
																		echo renderLang(${$field_name}).'が<strong>'.$from_val.'</strong>から<strong>'.$to_val.'</strong>に変更されました。<br>';
																		break;
																}
															}

														} else {
															echo '-';
														}

													echo '</td>';

													// TIMESTAMP
													echo '<td>'.formatDate($data['epoch_time'], true, false, true).'</td>';

												echo '</tr>';
											}

										}
										?>
									</tbody>
								</table>
							</div><!-- table-responsive -->

							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/pagination-bottom.php'); ?>
							
						</div>
					</div><!-- card -->

				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
    $(function(){
        $('.date').each(function(){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

    });
    </script>
	
</body>

</html>
<?php
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>