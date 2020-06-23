<li class="nav-item">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-bell fa-lg"></i>
        <span class="badge badge-danger navbar-badge" id="notif-count"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right mr-5">
        <span class="dropdown-item dropdown-header" id="notif-count-msg"></span>
        <?php 

        $notif_permissions_arr = array();
        foreach($_SESSION['sys_permissions'] as $permission) {
            if(strpos($permission, 'notification-') !== FALSE){
                $notif_permissions_arr[] = '"'.str_replace('notification-', '', $permission).'"';
            }
        }

        if(!empty($notif_permissions_arr)) {
            $notif_permissions_search = "AND module IN (".implode(', ', $notif_permissions_arr).")";
        } else {
            $notif_permissions_search = "AND module IN ('no-permission')";
        }
        
        $notif_count = 0;
        if(checkPermission('notifications')) {
            $notif_count = getField("count(id)", "fpd_notifications", "user_id = ".$_SESSION['sys_id']." AND account_mode = '".$_SESSION['sys_account_mode']."' AND status IS NULL ".$notif_permissions_search);
        }

        $sql_notif = $pdo->prepare("SELECT * FROM fpd_notifications WHERE user_id = :user_id AND account_mode = :account_mode AND status IS NULL $notif_permissions_search ORDER BY date DESC LIMIT 5");
        $sql_notif->bindParam(":user_id", $_SESSION['sys_id']);
        $sql_notif->bindParam(":account_mode", $_SESSION['sys_account_mode']);
        $sql_notif->execute();
        if(checkPermission('notifications')) {
            if($sql_notif->rowCount()) {
                while($notif = $sql_notif->fetch(PDO::FETCH_ASSOC)) {
                    
                    $notif_table = '';
                    $notif_href= '';
                    if($notif['module'] == 'day-plan') {
                        $notif_href = '/edit-30-60-90-day-plan/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if($notif['module'] == 'pre-operation-audit-QEHS') {
                        $notif_href = '/pre-operation-audit-checklist/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if($notif['module'] == 'pre-operation-audit-TSA') {
                        $notif_href = '/edit-tsa-pre-operation-audit/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if($notif['module'] == 'prospecting') {
                        $notif_href = '/edit-prospecting/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if ($notif['module'] == 'notice-to-proceed') {
                        $notif_href = '/notice-to-proceed/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if ($notif['module'] == 'billing-advice') {
                        $notif_href = '/downpayment/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if ($notif['module'] == 'contract') {
                        $notif_href ='/contract/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if ($notif['module'] == 'gate-pass-employee') {
                        $notif_href ='/gate-pass-employee/'.$notif['module_id'];
                        $notif_table = '';
                    }
                    if ($notif['module'] == 'visitor') {
                        $notif_href ='/visitor/'.$notif['module_id'];
                        $notif_table = 'properties';
                    }
                    if ($notif['module'] == 'prf') {
                        $notif_href ='/prf/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if ($notif['module'] == 'pre-operation-audit-iad') {
                        $notif_href ='/add-iad-on-hand-collection';
                        $notif_table = 'prospecting';
                    }
                    if ($notif['module'] == 'pre-operation-audit-pad-pcc') {
                        $notif_href ='/pre-operation-audit-pad-list';
                        $notif_table = 'prospecting';
                    }
                    if ($notif['module'] == 'nni-status-completed' || $notif['module'] == 'nni-it-status-completed' || $notif['module'] == 'cad-information' || $notif['module'] == 'nni' || $notif['module'] == 'it-information' || $notif['module'] == 'nni-status-endorsed' || $notif['module'] == 'nni-cad-status-completed' || $notif['module'] == 'nni-hr-status-completed' || $notif['module'] == 'nni-cad-status-completed' || $notif['module'] == 'nni-status-assigned' || $notif['module'] == 'nni-status-for-execution') {
                        $notif_href ='/edit-nni/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if ($notif['module'] == 'minutes-of-meeting') {
                        $notif_href ='/edit-minutes-of-meeting/'.$notif['module_id'];
                        $notif_table = 'departments';
                    }
                    if ($notif['module'] == 'property') {
                        $notif_href ='/property/'.$notif['module_id'];
                        $notif_table = 'property';
                    }
                    if ($notif['module'] == 'other-task') {
                        $href ='/pre-operation-other-tasks';
                        $notif_table = 'property';
                    }
                    if($notif['module'] == 'prospecting-activity') {
                        $notif_href ='/prospect-activities/'.$notif['module_id'];
                        $notif_table = 'prospecting';
                    }
                    if($notif['module'] == 'other-task-activities') {
                        $notif_href = '/add-activities-pre-operation-other-task/'.$notif['module_id']; 
                        $notif_table = 'other_tasks';
                    }
                    if($notif['module'] == 'undeposited-collection') {
                        $notif_href = '/on-hand-collection/'.$notif['module_id']; 
                        $notif_table = 'undeposited';
                    }
                    if($notif['module'] == 'general-inspection-and-function-check' || $notif['module'] == 'proper-installation-general-inspection-and-function-check' || $notif['module'] == 'supply-voltage-and-load-current-reading' || $notif['module'] == 'power-and-grounding-wirings') {
    
                        $notif_href = '/inspection-types/0'; 
                        $notif_table = 'engineering-checklist';
                    }
                    if($notif['module'] == 'fcu-monthly-inspections') {
                        $notif_href = '/fcu-monthly-inspection-list'; 
                        $notif_table = 'fcu-monthly-inspections';
                    }
                    if($notif['module'] == 'check-voucher') {
                        $notif_href = '/edit-check-voucher/'.$notif['module_id'];
                        $notif_table = 'check-voucher';
                    }
                    if($notif['module'] == 'daily-collection') {
                        $notif_href = '/daily-collection/'.$notif['module_id']; 
                        $notif_table = 'daily-collection';
                    }
                    if($notif['module'] == 'calibration-monitoring') {
                        $notif_href = '/edit-calibration/'.$notif['module_id']; 
                        $notif_table = 'calibration';
                    }
                    if($notif['module'] == 'calibration-plans') {
                        $notif_href = '/calibration-plan-edit/'.$notif['module_id']; 
                        $notif_table = 'calibration';
                    }
                    if($notif['module'] == 'proposal-introductory-letter') {
                        $notif_href = '/edit-bdmd-introductory-letter-proposal/'.$notif['module_id']; 
                        $notif_table = 'proposal';
                    }
                    if($notif['module'] == 'labor-cost-add' || $notif['module'] == 'labor-cost-edit' || $notif['module'] == 'labor-cost-returned' || $notif['module'] == 'labor-cost-approved') {
                        $notif_href = '/edit-labor-cost/'.$notif['module_id'];
                        $notif_table = 'labor-cost';
                    }
                    if ($notif['module'] == 'daily-collection-report') {
                        $notif_href = '/daily-collection-report/'.$notif['module_id'];
                        $notif_table = 'daily-collection-report';
                    }
                    if ($notif['module'] == 'daily-deposit-add') {
                        $notif_href = '/daily-deposit/'.$notif['module_id'];
                        $notif_table = 'daily-deposit';
                    }
                    if ($notif['module'] == 'pre-operations-audit-pad-checklist') {
                        $notif_href = '/pad-pre-operation-audit-checklist/'.$notif['module_id'];
                        $notif_table = 'pre-operations-audit-pad-checklist';
                    }
                    if ($notif['module'] == 'pre-operations-audit-pad-pcv') {
                        $notif_href = '/pad-pcv-pre-operation-audit-list';
                        $notif_table = 'pre-operations-audit-pad-pcv';
                    }
                    if ($notif['module'] == 'pre-operations-audit-tsa') {
                        $notif_href = '/tsa-report-findings/'.$notif['module_id'];
                        $notif_table = 'pre-operations-audit-tsa';
                    }
                    if ($notif['module'] == 'operations-audit-tsa') {
                        $notif_href = '/tsa-operations-audit/'.$notif['module_id'];
                        $notif_table = 'operations-audit-tsa';
                    }
                    if ($notif['module'] == 'service-requests') {
                        $notif_href = '/service-request/'.$notif['module_id'];
                        $notif_table = 'service-requests';
                    }
    
                    $notification_msg = '';
    
                    if($notif['source_account_mode'] == 'employee') {
                        $notif_code_name = getField('code_name', 'employees', 'id = '.$notif['source_id']);
                        $notification_msg = !empty($notif_code_name) ? $notif_code_name : getFullName($notif['source_id'], $notif['source_account_mode']);
                    } else {
                        $notification_msg = getFullName($notif['source_id'], $notif['source_account_mode']);
                    }
    
                    $notification_msg .= ' '.renderlang(${"notification_".$notif['notification']});
                    
                    $notif_target = '';
    
                    switch($notif_table)  {
                        case 'prospecting':
                            $notif_target = '['.getField("project_name", "prospecting", 'id = '.$notif['module_id']).']';
                            break;
                        case 'departments':
                            $notif_target = '['.getField("department_name", "departments", 'id = '.$notif['module_id']).']';
                            break;
                        case 'other_tasks': 
                            $notif_target = '['.getField("title", "other_tasks", 'id = '.$notif['module_id']).']';
                            break;
    
                        // UNDEPOSITED
                        case 'undeposited':
                            $target_id = getField('property_id', 'on_hand_collection', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField("property_name", "properties", "id = ".$target_id).']';
                            }
                            break;
    
                        case 'engineering-checklist':
                            $target_id = getField('sub_property_id', 'task_inspection_engineering_checklist', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField("sub_property_name", "sub_properties", "id =".$target_id).']';
                            }
                            break;
                        case 'fcu-monthly-inspections':
                            $target_id = getField('sub_property_id', 'task_inspection_maintenance_fcu', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField("sub_property_name", "sub_properties", "id =".$target_id).']';
                            }
                            break;
                        case 'check-voucher':
                            $target_id = getField('property_id', 'check_voucher', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField('property_name', 'properties', 'id = '.$target_id).']';
                            }
                            break;
                            
                        // DAILY COLLECTION
                        case 'daily-collection':
                            $target_id = getField('sub_property_id', 'daily_collections', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField("sub_property_name", "sub_properties", "id =".$target_id).']';
                            }
                            break;
    
                        // CALIBRATION
                        case 'calibration':
                            $target_id = getField('sub_property_id', 'calibrations', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField("sub_property_name", "sub_properties", "id =".$target_id).']';
                            }
                            break;
    
                        // PROPOSAL
                        case 'proposal':
                            $target_id = getField('prospect_id', 'proposal_introductory_letters', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField("project_name", "prospecting", "id =".$target_id).']';
                            }
                            break;
    
                        // LABOR COST
                        case 'labor-cost':
                            $target_id = getField('prospect_id', 'labor_cost', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                            }
                            break;
    
                        // DAILY COLLECTION REPORT
                        case 'daily-collection-report':
                            $target_id = getField('sub_property_id', 'daily_collection_reports', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField('sub_property_name', 'sub_properties', 'id = '.$target_id).']';
                            }
                            break;
    
                        // DAILY DEPOSIT
                        case 'daily-deposit':
                            $target_id = getField('sub_property_id', 'daily_deposit', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField('sub_property_name', 'sub_properties', 'id = '.$target_id).']';
                            }
                            break;
    
                        // PRE OPERATIONS AUDIT PAD CHECKLIST
                        case 'pre-operations-audit-pad-checklist':
                            $target_id = getField('prospect_id', 'pre_ops_pad_checklist', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                            }
                            break;
    
                        // PRE OPERATIONS AUDIT PAD PCV
                        case 'pre-operations-audit-pad-pcv':
                            $target_id = getField('prospect_id', 'poa_pad_pcv', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                            }
                            break;
    
                        // PRE OPERATIONS AUDIT TSA
                        case 'pre-operations-audit-tsa':
                            $target_id = getField('prospect_id', 'pre_operation_audit_tsa', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                            }
                            break;

                        // OPERATIONS AUDIT TSA
                        case 'operations-audit-tsa':
                            $target_id = getField('prospect_id', 'operations_audit_tsa', 'id = '.$notif['module_id']);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                            }
                            break;

                        // SERVICE REQUESTS
                        case 'service-requests':
                            $unit_id = getField('unit_id', 'service_requests', 'id = '.$notif['module_id']);
                            $target_id = getField('sub_property_id', 'units', 'id = '.$unit_id);
                            if(checkVar($target_id)) {
                                $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                            }
                            break;
    
                        default: 
                            $notif_target = '';
                            break;
                    }
                    ?>
    
                    <div class="dropdown-divider"></div>
                    <a href="'.$notif_href.'" class="dropdown-item notif-stat" data-id="'.$notif['id'].'">
                        <p><?php echo $notification_msg.' '.$notif_target; ?></p>
                        <span class="float-right text-muted text-sm"><? echo formatDate($notif['date'], true, false, true); ?></span>
                    </a>
                    <?php
                }
            }
        }
        ?>
        <div class="dropdown-divider"></div>
        <a href="/notifications" class="dropdown-item dropdown-footer" id="notif-clear">See All Notifications</a>
    </div>
</li>