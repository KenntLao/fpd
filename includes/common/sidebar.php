<aside class="main-sidebar sidebar-dark-white elevation-4 pms-red">

    <!-- LOGO -->
    <a href="/dashboard" class=" border-0">
        <div class="container-fluid mb-1 bg-white p-2">
            <div class="row">
                <img src="/assets/images/NEXUS-Logo_2.gif" alt="Raianseier" class="mt-2 brand-image elevation-3 m-auto" style="width: 80%;">
            </div>
        </div>
    </a>

    <!-- SIDEBAR -->
    <div class="sidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- DASHBOARD -->
                <li class="nav-item ">
                    <a href="/dashboard" class="nav-link<?php if ($page == 'dashboard') {
                                                            echo ' active';
                                                        } ?>">
                        <i class="nav-icon fas fa-list-ul"></i>
                        <p><?php echo renderLang($dashboard_dashboard); ?></p>
                    </a>
                </li>

                <!-- MY TASKS -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fas fa-edit nav-icon"></i>
                        <p>My Tasks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/hris" class="nav-link">
                        <i class="fas nav-icon fa-users"></i>
                        <p>HRIS</p>
                    </a>
                </li>

                <!-- CALENDAR -->
                <li class="nav-item">
                    <a href="/calendar" class="nav-link <?php echo $page == 'calendar' ? 'active' : ''; ?>">
                        <i class="far fa-calendar-alt nav-icon"></i>
                        <p>Calendar</p>
                    </a>
                </li>

                <!-- OTHER TASK -->
                <?php if (checkPermission('pre-operation-other-tasks')) { ?>
                    <li class="nav-item">
                        <a href="/pre-operation-other-tasks" class="nav-link<?php echo $page == 'pre-operation-other-tasks' ? ' active' : ''; ?>">
                            <i class="fas fa-th nav-icon"></i>
                            <p><?php echo renderLang($po_other_task); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <li class="nav-item has-treeview font-weight-bold">
                    <a href="#" class="nav-link">
                        <p>
                            Pre Operations
                        </p>
                    </a>
                </li>

                <!-- prospecting -->
                <?php if (checkPermission('prospecting')) { ?>
                    <li class="nav-item">
                        <a href="/prospecting-departments" class="nav-link<?php echo $page == 'prospecting' ? ' active' : '' ?>">
                            <i class="fas fa-binoculars nav-icon"></i>
                            <p><?php echo renderLang($prospecting); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <!-- PROPOSALS -->
                <?php if (checkPermission('proposal-bdd') || checkPermission('proposal-esd') || checkPermission('proposal-pod')) { ?>
                    <li class="nav-item">
                        <a href="/proposal-category" class="nav-link<?php echo $page == 'proposal' ? ' active' : '' ?>">
                            <i class="fas fa-handshake nav-icon"></i>
                            <p><?php echo renderLang($proposals); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <!-- NOTICE TO PROCEED -->
                <?php if (checkPermission('notice-to-proceed')) { ?>
                    <li class="nav-item">
                        <a href="/notice-to-proceed-list" class="nav-link<?php echo $page == 'notice-to-proceed' ? ' active' : '' ?>">
                            <i class="fas fa-file-signature nav-icon"></i>
                            <p><?php echo renderLang($notice_to_proceed); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <!-- NOTICE OF NEW INSTRUCTIONS -->
                <?php if (checkPermission('notice-of-new-instructions')) { ?>
                    <li class="nav-item">
                        <a href="/notice-of-new-instructions" class="nav-link<?php echo $page == 'notice-of-new-instructions' ? ' active' : '' ?>">
                            <i class="far fa-file-alt nav-icon"></i>
                            <p><?php echo renderLang($notice_of_new_instruction); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <!-- CONTRACT -->
                <?php if (checkPermission('contract')) { ?>
                    <li class="nav-item">
                        <a href="/contract-list" class="nav-link<?php echo $page == 'contract' ? ' active' : '' ?>">
                            <i class="fas fa-file-contract nav-icon"></i>
                            <p><?php echo renderLang($contract_FPD_contract); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <!-- BILLING ADVICE -->
                <?php if (checkPermission('billing-advice')) { ?>
                    <li class="nav-item">
                        <a href="/downpayments" class="nav-link<?php echo $page == 'billing-advice' ? ' active' : '' ?>">
                            <i class="fas fa-coins nav-icon"></i>
                            <p><?php echo renderLang($downpayment); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <!-- PRF -->
                <?php if (checkPermission('prf')) { ?>
                    <li class="nav-item">
                        <a href="/prf-list" class="nav-link<?php echo $page == 'prf' ? ' active' : '' ?>">
                            <i class="fas fa-people-carry nav-icon"></i>
                            <p><?php echo renderLang($prf); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <!-- PRE OPERATION AUDIT -->
                <?php if (checkPermission('pre-operation-audit')) { ?>
                    <li class="nav-item">
                        <a href="/pre-operation-audit-departments" class="nav-link<?php echo $page == 'pre-operation-audit' ? ' active' : ''; ?>">
                            <i class="fas fa-clipboard-check nav-icon"></i>
                            <p><?php echo renderLang($pre_operation_audit); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <!-- 30-60-90 DAYS -->
                <?php if (checkPermission('30-60-90-days')) { ?>
                    <li class="nav-item">
                        <a href="/30-60-90-day-plans" class="nav-link<?php echo $page == 'day-plans' ? ' active' : ''; ?>">
                            <i class="far fa-calendar-alt nav-icon"></i>
                            <p>30-60-90 Days</p>
                        </a>
                    </li>
                <?php } ?>

                <?php if (checkPermission('property-profile')) { ?>
                    <li class="nav-item has-treeview <?php echo $page == 'clients' || $page == "properties" || $page == 'unit-add-eu' || $page == 'employee-timesheet' || $page == 'unit-owners' || $page == 'tenants' || $page == 'occupants' || $page == 'employees' || $page == 'departments' ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hands"></i>
                            <p>Property Profile
                                <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview pl-3">

                            <?php if (checkPermission('clients')) { ?>
                                <!-- CLIENTS -->
                                <li class="nav-item">
                                    <a href="/clients" class="nav-link<?php if ($page == 'clients') {
                                                                            echo ' active';
                                                                        } ?>">
                                        <p><?php echo renderLang($clients_clients); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('properties')) { ?>
                                <!-- PROPERTIES -->
                                <li class="nav-item">
                                    <a href="/properties" class="nav-link<?php if ($page == 'properties') {
                                                                                echo ' active';
                                                                            } ?>">
                                        <p><?php echo renderLang($properties_properties); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('unit-add-eu')) { ?>
                                <!-- ADD UNIT -->
                                <li class="nav-item">
                                    <a href="/add-unit-eu" class="nav-link<?php if ($page == 'unit-add-eu') {
                                                                                echo ' active';
                                                                            } ?>">
                                        <p><?php echo renderLang($units_add_unit); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($_SESSION['sys_account_mode'] == 'employee') { ?>
                                <!-- TIME SHEET -->
                                <li class="nav-item">
                                    <a href="/employee-timesheet/<?php echo $_SESSION['sys_id'] ?>" class="nav-link<?php if ($page == 'employee-timesheet') {
                                                                                                                        echo ' active';
                                                                                                                    } ?>">
                                        <p><?php echo renderLang($employees_time_sheet); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('unit-owners')) { ?>
                                <!-- UNIT OWNERS -->
                                <li class="nav-item">
                                    <a href="/unit-owners" class="nav-link<?php if ($page == 'unit-owners') {
                                                                                echo ' active';
                                                                            } ?>">
                                        <p><?php echo renderLang($unit_owners_unit_owners); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('tenants')) { ?>
                                <!-- TENANTS -->
                                <li class="nav-item">
                                    <a href="/tenants" class="nav-link<?php if ($page == 'tenants') {
                                                                            echo ' active';
                                                                        } ?>">
                                        <p><?php echo renderLang($tenants_tenants); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('occupants')) { ?>
                                <!-- OCCUPANTS -->
                                <li class="nav-item">
                                    <a href="/occupants" class="nav-link<?php if ($page == 'occupants') {
                                                                            echo ' active';
                                                                        } ?>">
                                        <p><?php echo renderLang($occupants_occupants); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('employees')) { ?>
                                <!-- EMPLOYEES -->
                                <li class="nav-item">
                                    <a href="/employees" class="nav-link<?php if ($page == 'employees') {
                                                                            echo ' active';
                                                                        } ?>">
                                        <p><?php echo renderLang($employees_employees); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('departments')) { ?>
                                <!-- DEPARTMENT -->
                                <li class="nav-item">
                                    <a href="/departments" class="nav-link<?php if ($page == 'departments') {
                                                                                echo ' active';
                                                                            } ?>">
                                        <p><?php echo renderLang($departments_departments); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if (checkPermission('tasks')) { ?>
                    <li class="nav-item has-treeview font-weight-bold">
                        <a href="#" class="nav-link">
                            <p>
                                Operations
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <?php if (checkPermission('tasks')) { ?>
                    <li class="nav-item has-treeview <?php echo $page == 'preventive-maintenance' || $page == 'job-order' || $page == 'inspections' || $page == 'work-orders' || $page == 'collections' || $page == 'operation-audit' || $page == 'permits-and-licences' || $page == 'calibration' ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                Task
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview pl-3">

                            <?php if (checkPermission('inspections')) { ?>
                                <li class="nav-item">
                                    <a href="/inspection-categories" class="nav-link <?php echo $page == 'inspections' ? 'active' : ''; ?>">
                                        <p><?php echo renderLang($inspection); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('preventive-maintenance')) { ?>
                                <li class="nav-item">
                                    <a href="/frequency-preventive-maintenance/6" class="nav-link <?php echo $page == 'preventive-maintenance' ? 'active' : ''; ?>">
                                        <p><?php echo renderLang($preventive_maintenance); ?></p>
                                    </a>
                                </li>
                            <?php } ?>


                            <!-- CALIBRATION-->
                            <?php if (checkPermission('calibrations')) { ?>
                                <li class="nav-item">
                                    <a href="/calibration-category" class="nav-link <?php echo $page == 'calibration' ? 'active' : ''; ?>">
                                        <p><?php echo renderLang($calibration); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('job-orders')) { ?>
                                <li class="nav-item">
                                    <a href="/job-orders" class="nav-link <?php echo $page == 'job-order' ? 'active' : ''; ?>">
                                        <p><?php echo renderLang($job_orders_job_order); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('work-orders')) { ?>
                                <li class="nav-item">
                                    <a href="/work-orders" class="nav-link <?php echo $page == 'work-orders' ? 'active' : ''; ?>">
                                        <p><?php echo renderLang($work_order); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('daily-collections')) { ?>
                                <li class="nav-item">
                                    <a href="/collections" class="nav-link <?php echo $page == 'collections' ? 'active' : ''; ?>">
                                        <p>Collection</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('audits')) { ?>
                                <li class="nav-item">
                                    <a href="/audits" class="nav-link<?php echo $page == 'operation-audit' ? ' active' : ''; ?>">
                                        <p>Audit</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('communication-managements')) { ?>
                                <li class="nav-item">
                                    <a href="pages/charts/flot.html" class="nav-link">
                                        <p>Communications Management</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('permits-licences')) { ?>
                                <li class="nav-item">
                                    <a href="/permits-and-licences-list" class="nav-link <?php echo $page == 'permits-and-licences' ? 'active' : ''; ?>">
                                        <p><?php echo renderLang($permits_and_licences); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('filing-system')) { ?>
                                <li class="nav-item">
                                    <a href="pages/charts/chartjs.html" class="nav-link">
                                        <p>Filing System</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <!-- INCIDENT REPORT -->
                <?php if (checkPermission('incident-reports')) { ?>
                    <li class="nav-item">
                        <a href="/incident-reports" class="nav-link<?php echo $page == 'incident-reports' ? ' active' : ''; ?>">
                            <i class="fas fa-dumpster-fire nav-icon"></i>
                            <p><?php echo renderLang($incident_report); ?></p>
                        </a>
                    </li>
                <?php } ?>

                <?php if (checkPermission('document-management')) { ?>
                    <li class="nav-item has-treeview <?php echo $page == 'minutes-of-meeting' || $page == 'permits-and-licences' || $page == 'contracts' ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-file-alt"></i>
                            <p>
                                Document Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview pl-3">

                            <?php if (checkPermission('201-files')) { ?>
                                <li class="nav-item">
                                    <a href="pages/charts/chartjs.html" class="nav-link">
                                        <p>201 Files</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('minutes-of-meeting')) { ?>
                                <li class="nav-item">
                                    <a href="/minutes-of-meeting-list" class="nav-link <?php echo $page == 'minutes-of-meeting' ? 'active' : ''; ?>">
                                        <p><?php echo renderLang($minutes_of_meeting); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('boards')) { ?>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <p>Board</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('agmms')) { ?>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <p>AGMM</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('announcements')) { ?>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <p>Announcement</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('memos')) { ?>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <p>Memos</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('rsvp')) { ?>
                                <li class="nav-item">
                                    <a href="pages/charts/flot.html" class="nav-link">
                                        <p>RSVP</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('doc-contracts')) { ?>
                                <li class="nav-item">
                                    <a href="/doc-management-contracts" class="nav-link<?php echo $page == 'contracts' ? ' active' : ''; ?>">
                                        <p><?php echo renderLang($contracts); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('property-handbook')) { ?>
                                <li class="nav-item">
                                    <a href="/property-handbook" class="nav-link<?php echo $page == 'property-handbook' ? ' active' : ''; ?>">
                                        <p><?php echo renderLang($property_handbook); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <!-- POST OPERATIONS -->
                <?php if (checkPermission('post-operations')) { ?>
                    <li class="nav-item has-treeview font-weight-bold">
                        <a href="#" class="nav-link">
                            <p>
                                Post Operations
                            </p>
                        </a>
                    </li>

                    <!-- COLLECT -->
                    <?php if (checkPermission('collects')) { ?>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-hand-holding-usd nav-icon"></i>
                                <p>Collect</p>
                            </a>
                        </li>
                    <?php } ?>

                    <!-- TURNOVER AUDIT -->
                    <?php if (checkPermission('turnover-audits')) { ?>
                        <li class="nav-item">
                            <a href="/turnover-audit-tsa-list" class="nav-link<?php echo $page == 'turnover-audit' ? ' active' : ''; ?>">
                                <i class="fas fa-sign-in-alt nav-icon"></i>
                                <p><?php echo renderLang($turnover_audit); ?></p>
                            </a>
                        </li>
                    <?php } ?>

                    <!-- POST OPERATIONS CONTRACT -->
                    <?php if (checkPermission('contract-terminated')) { ?>
                        <li class="nav-item">
                            <a href="/contract-terminated-list" class="nav-link<?php echo $page == 'contract-teminated' ? ' active' : '' ?>">
                                <i class="fas fa-file-contract nav-icon"></i>
                                <p><?php echo renderLang($contract); ?></p>
                            </a>
                        </li>
                    <?php } ?>

                <?php } ?>

                <!-- REPORT -->
                <?php if (checkPermission('reports')) { ?>
                    <li class="nav-item has-treeview font-weight-bold">
                        <a href="#" class="nav-link">
                            <p>
                                Reports
                            </p>
                        </a>
                    </li>

                    <!-- ACCOUNTING -->
                    <?php if (checkPermission('accounting')) { ?>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-calculator nav-icon"></i>
                                <p>Accounting</p>
                            </a>
                        </li>
                    <?php } ?>

                    <!-- ADMIN -->
                    <?php if (checkPermission('admin')) { ?>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-user-circle nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>

                <!-- HELP DESK -->
                <?php if (checkPermission('customer-service')) { ?>
                    <li class="nav-item has-treeview font-weight-bold">
                        <a href="#" class="nav-link">
                            <p>
                                Customer Service
                            </p>
                        </a>
                    </li>

                    <!-- SERVICE REQUEST -->
                    <?php if (checkPermission('service-requests')) { ?>
                        <li class="nav-item">
                            <a href="/service-requests" class="nav-link<?php echo $page == 'service-requests' ? ' active' : '' ?>">
                                <i class="fas fa-exclamation-circle nav-icon"></i>
                                <p><?php echo renderLang($service_requests); ?></p>
                            </a>
                        </li>
                    <?php } ?>

                    <!-- GATE PASS -->
                    <li class="nav-item has-treeview <?php echo $page == 'visitors' || $page == 'move-inout-requests' || $page == 'service-providers' || $page == 'gate-pass-employees' || $page == 'mail-logs' ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>
                                <?php echo renderLang($gate_pass); ?>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview pl-3">

                            <!-- VISITORS -->
                            <?php if (checkPermission('visitors')) { ?>
                                <li class="nav-item">
                                    <a href="/visitors" class="nav-link <?php echo $page == 'visitors' ? ' active' : '' ?>">
                                        <p><?php echo renderLang($visitors); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <!-- MOVE IN/OUT REQUESTS -->
                            <?php if (checkPermission('move-inout-requests')) { ?>
                                <li class="nav-item">
                                    <a href="/move-inout-requests" class="nav-link <?php echo $page == 'move-inout-requests' ? ' active' : '' ?>">
                                        <p><?php echo renderLang($move_inout_requests); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <!-- SERVICE PROVIDERS -->
                            <?php if (checkPermission('service-providers')) { ?>
                                <li class="nav-item">
                                    <a href="/service-providers" class="nav-link <?php echo $page == 'service-providers' ? ' active' : '' ?>">
                                        <p><?php echo renderLang($service_providers); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <!-- GATE PASS EMPLOYEES -->
                            <?php if (checkPermission('gate-pass-employees')) { ?>
                                <li class="nav-item">
                                    <a href="/gate-pass-employees" class="nav-link <?php echo $page == 'gate-pass-employees' ? ' active' : '' ?>">
                                        <p><?php echo renderLang($gate_pass_employees); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <!-- MAIL loGS -->
                            <?php if (checkPermission('mail-logs')) { ?>
                                <li class="nav-item">
                                    <a href="/mail-logs" class="nav-link <?php echo $page == 'mail-logs' ? ' active' : '' ?>">
                                        <p><?php echo renderLang($mail_logs); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>

                    <!-- RESERVATION -->
                    <li class="nav-item has-treeview <?php echo $page == 'boardrooms' || $page == 'amenities' ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-calendar-minus"></i>
                            <p>
                                <?php echo renderLang($reservation); ?>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview pl-3">

                            <!-- BOARDROOM -->
                            <?php if (checkPermission('boardrooms')) { ?>
                                <li class="nav-item">
                                    <a href="/boardrooms" class="nav-link <?php echo $page == 'boardrooms' ? ' active' : '' ?>">
                                        <p><?php echo renderLang($boardrooms); ?></p>
                                    </a>
                                </li>
                            <?php } ?>

                            <!-- AMENITIES -->
                            <?php if (checkPermission('amenities')) { ?>
                                <li class="nav-item">
                                    <a href="/amenities" class="nav-link <?php echo $page == 'amenities' ? ' active' : '' ?>">
                                        <p><?php echo renderLang($amenities); ?></p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (checkPermission('market-place')) { ?>
                    <li class="nav-header font-weight-bold"></li>
                    <li class="nav-item has-treeview font-weight-bold">
                        <a href="#" class="nav-link">
                            <p>
                                Market Place
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview pl-3">

                            <!-- COOLFIX -->
                            <?php if (checkPermission('coolfix')) { ?>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <img src="/assets/images/coolfix/Coolfix.png" class="w40p" title="Coolfix">
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if (checkPermission('system')) { ?>
                    <li class="nav-item has-treeview font-weight-bold">
                        <a href="#" class="nav-link">
                            <p>
                                System
                            </p>
                        </a>
                    </li>

                    <?php if (checkPermission('users')) { ?>
                        <!-- USERS -->
                        <li class="nav-item">
                            <a href="/users" class="nav-link<?php if ($page == 'users') {
                                                                echo ' active';
                                                            } ?>">
                                <i class="nav-icon fas fa-user-secret"></i>
                                <p><?php echo renderLang($users_users); ?></p>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (checkPermission('clusters')) { ?>
                        <!-- CLUSTERS -->
                        <li class="nav-item">
                            <a href="/clusters" class="nav-link<?php if ($page == 'clusters') {
                                                                    echo ' active';
                                                                } ?>">
                                <i class="nav-icon fa fa-object-group"></i>
                                <p><?php echo renderLang($clusters); ?></p>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (checkPermission('roles')) { ?>
                        <!-- ROLES -->
                        <li class="nav-item">
                            <a href="/roles" class="nav-link<?php if ($page == 'roles') {
                                                                echo ' active';
                                                            } ?>">
                                <i class="nav-icon far fa-id-badge"></i>
                                <p><?php echo renderLang($roles_roles); ?></p>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (checkPermission('system-log')) { ?>
                        <!-- SYSTEM LOG -->
                        <li class="nav-item">
                            <a href="/system-log" class="nav-link<?php if ($page == 'system-log') {
                                                                        echo ' active';
                                                                    } ?>">
                                <i class="nav-icon fa fa-align-left"></i>
                                <p><?php echo renderLang($system_log_title); ?></p>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>

            </ul>
            <!-- /.sidebar-menu -->

        </nav>

        <div class="py-5 my-4">
        </div>

    </div>

    <div class="sidebar-footer">
        <div class="px-2 py-2 sidebar-footer-color">
            <div class="user-panel d-flex border-0">
                <div class="image my-auto mr-1">
                    <img src="<?php echo $_SESSION['sys_photo']; ?>" class="img-circle elevation-4" width="40">
                </div>
                <div class="info">
                    <p class="mb-0"><a href="/profile" class="text-white"><?php echo $_SESSION['sys_fullname']; ?></a></p>
                    <p class="mb-0 text-white">Admin</p>
                </div>
            </div>
        </div>
    </div>

</aside>