<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'MyFPD',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => 'My<b>FPD</b>',
    'logo_img' => null,
    'logo_img_class' => null,
    'logo_img_xl' => null,
    'logo_img_xl_class' => null,
    'logo_img_alt' => null,

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Extra Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#66-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => '',
    'classes_sidebar_nav' => '',
    'classes_topnav' => '',
    'classes_topnav_nav' => 'navbar-expand-md navbar-white navbar-light',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    'password_reset_url' => 'password/reset',

    'password_email_url' => 'password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        'ADMINISTRATION',
        [
            'text' => 'Admin',
            'icon' => 'fas fa-fw fa-cubes',
            'submenu' => [
                [   
                    'text' => 'Company Structure',
                    'icon' => 'fas fa-fw fa-building',
                    'url' => '/hris/pages/admin/company/index',
                    'active' => ['/hris/pages/admin/company/create', '/hris/pages/admin/company/index', '/hris/pages/admin/company/*/edit', 'regex:@^content/[0-9]+$@']
                ],
                [
                    'text' => 'Job Details Setup',
                    'icon' => 'fas fa-fw fa-columns',
                    'submenu' => [
                        [
                            'text' => 'Job Titles',
                            'icon' => 'fas fa-fw fa-columns',
                            'url' => '/hris/pages/admin/jobDetails/jobTitles/index',
                            'active' => ['/hris/pages/admin/jobDetails/jobTitles/create', '/hris/pages/admin/jobDetails/jobTitles/index', '/hris/pages/admin/jobDetails/jobTitles/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Pay Grades',
                            'icon' => 'fas fa-fw fa-columns',
                            'url' => '/hris/pages/admin/jobDetails/payGrades/index',
                            'active' => ['/hris/pages/admin/jobDetails/payGrades/create', '/hris/pages/admin/jobDetails/payGrades/index', '/hris/pages/admin/jobDetails/payGrades/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Employment Status',
                            'icon' => 'fas fa-fw fa-columns',
                            'url' => '/hris/pages/admin/jobDetails/employmentStatuses/index',
                            'active' => ['/hris/pages/admin/jobDetails/employmentStatuses/create', '/hris/pages/admin/jobDetails/employmentStatuses/index', '/hris/pages/admin/jobDetails/employmentStatuses/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                    ]
                ],
                [
                    'text' => 'Qualifications Setup',
                    'icon' => 'fas fa-fw fa-check-square',
                    'submenu' => [
                        [
                            'text' => 'Skills',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/skills/index',
                            'active' => ['/hris/pages/admin/qualifications/skills/create', '/hris/pages/admin/qualifications/skills/index', '/hris/pages/admin/qualifications/skills/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Education',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/educations/index',
                            'active' => ['/hris/pages/admin/qualifications/educations/create', '/hris/pages/admin/qualifications/educations/index', '/hris/pages/admin/qualifications/educations/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Certifications',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/certifications/index',
                            'active' => ['/hris/pages/admin/qualifications/certifications/create', '/hris/pages/admin/qualifications/certifications/index', '/hris/pages/admin/qualifications/certifications/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Languages',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/languages/index',
                            'active' => ['/hris/pages/admin/qualifications/languages/create', '/hris/pages/admin/qualifications/languages/index', '/hris/pages/admin/qualifications/languages/*/edit', 'regex:@^content/[0-9]+$@']
                        ]
                    ]
                ],
                [
                    'text' => 'Training Setup',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'submenu' => [
                        [
                            'text' => 'Courses',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'url' => '/hris/pages/admin/training/courses/index',
                            'active' => ['/hris/pages/admin/training/courses/create', '/hris/pages/admin/training/courses/index', '/hris/pages/admin/training/courses/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Training Sessions',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'url' => '/hris/pages/admin/training/trainingSessions/index',
                            'active' => ['/hris/pages/admin/training/trainingSessions/create', '/hris/pages/admin/training/trainingSessions/index', '/hris/pages/admin/training/trainingSessions/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Employee Training Sessions',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'url' => '/hris/pages/admin/training/employeeTrainingSessions/index',
                            'active' => ['/hris/pages/admin/training/employeeTrainingSessions/create', '/hris/pages/admin/training/employeeTrainingSessions/index', '/hris/pages/admin/training/employeeTrainingSessions/*/edit', 'regex:@^content/[0-9]+$@']
                        ]
                    ]
                ],
                [
                    'text' => 'Properties Setup',
                    'icon' => 'fas fa-fw fa-list-alt',
                    'submenu' => [
                        [
                            'text' => 'Clients',
                            'icon' => 'fas fa-fw fa-list-alt',
                            'url' => '/hris/pages/admin/properties/clients/index',
                            'active' => ['/hris/pages/admin/properties/clients/create', '/hris/pages/admin/properties/clients/index', '/hris/pages/admin/properties/clients/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Projects',
                            'icon' => 'fas fa-fw fa-list-alt',
                            'url' => '/hris/pages/admin/properties/projects/index',
                            'active' => ['/hris/pages/admin/properties/projects/create', '/hris/pages/admin/properties/projects/index', '/hris/pages/admin/training/properties/projects/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Employee Projects',
                            'icon' => 'fas fa-fw fa-list-alt',
                            'url' => '/hris/pages/admin/properties/employeeProjects/index',
                            'active' => ['/hris/pages/admin/properties/employeeProjects/create', '/hris/pages/admin/properties/employeeProjects/index', '/hris/pages/admin/properties/employeeProjects/*/edit', 'regex:@^content/[0-9]+$@']
                        ]
                    ]
                ],
                [
                    'text' => 'Leave Settings',
                    'icon' => 'fas fa-fw fa-pause',
                    'submenu' => [
                        [
                            'text' => 'Leave Types',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leaveTypes/index',
                            'active' => ['/hris/pages/admin/leave/leaveTypes/create', '/hris/pages/admin/leave/leaveTypes/index', '/hris/pages/admin/leave/leaveTypes/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Leave Period',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leavePeriods/index',
                            'active' => ['/hris/pages/admin/leave/leavePeriods/create', '/hris/pages/admin/leave/leavePeriods/index', '/hris/pages/admin/leave/leavePeriods/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Work Week',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/workWeeks/index',
                            'active' => ['/hris/pages/admin/leave/workWeeks/create', '/hris/pages/admin/leave/workWeeks/index', '/hris/pages/admin/leave/workWeeks/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Holidays',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/holidays/index',
                            'active' => ['/hris/pages/admin/leave/holidays/create', '/hris/pages/admin/leave/holidays/index', '/hris/pages/admin/leave/holidays/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Leave Rules',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leaveRules/index',
                            'active' => ['/hris/pages/admin/leave/leaveRules/create', '/hris/pages/admin/leave/leaveRules/index', '/hris/pages/admin/leave/leaveRules/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Paid Time Off',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/paidTimeOff/index',
                            'active' => ['/hris/pages/admin/leave/paidTimeOff/create', '/hris/pages/admin/leave/paidTimeOff/index', '/hris/pages/admin/leave/paidTimeOff/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Leave Groups',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leaveGroups/index',
                            'active' => ['/hris/pages/admin/leave/leaveGroups/create', '/hris/pages/admin/leave/leaveGroups/index', '/hris/pages/admin/leave/leaveGroups/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Leave Group Employee',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leaveGroupEmployees/index',
                            'active' => ['/hris/pages/admin/leave/leaveGroupEmployees/create', '/hris/pages/admin/leave/leaveGroupEmployees/index', '/hris/pages/admin/leave/leaveGroupEmployees/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Employee Leave List',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/employeeLeaveList/index',
                            'active' => ['/hris/pages/admin/leave/employeeLeaveList/create', '/hris/pages/admin/leave/employeeLeaveList/index', '/hris/pages/admin/leave/employeeLeaveList/*/edit', 'regex:@^content/[0-9]+$@']
                        ]
                    ]
                ],
                [
                    'text' => 'Benefits Administration',
                    'icon' => 'fas fa-fw fa-bars',
                    'submenu' => [
                        [
                            'text' => 'Expenses Categories',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '/hris/pages/admin/benefits/expensesCategories/index',
                            'active' => ['/hris/pages/admin/benefits/expensesCategories/create', '/hris/pages/admin/benefits/expensesCategories/index', '/hris/pages/admin/benefits/expensesCategories/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Payment Methods',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '/hris/pages/admin/benefits/paymentMethods/index',
                            'active' => ['/hris/pages/admin/benefits/paymentMethods/create', '/hris/pages/admin/benefits/paymentMethods/index', '/hris/pages/admin/benefits/paymentMethods/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Employee Expenses',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '/hris/pages/admin/benefits/employeeExpenses/index',
                            'active' => ['/hris/pages/admin/benefits/employeeExpenses/create', '/hris/pages/admin/benefits/employeeExpenses/index', '/hris/pages/admin/benefits/employeeExpenses/*/edit', 'regex:@^content/[0-9]+$@']
                        ]
                    ]
                ],
                [
                    'text' => 'Overtime Administration',
                    'icon' => 'fas fa-fw fa-align-center',
                    'submenu' => [
                        [
                            'text' => 'Categories',
                            'icon' => 'fas fa-fw fa-align-center',
                            'url' => '/hris/pages/admin/overtime/overtimeCategories/index',
                            'active' => ['/hris/pages/admin/overtime/overtimeCategories/create', '/hris/pages/admin/overtime/overtimeCategories/index', '/hris/pages/admin/overtime/overtimeCategories/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Requests',
                            'icon' => 'fas fa-fw fa-align-center',
                            'url' => '/hris/pages/admin/overtime/overtimeRequests/index',
                            'active' => ['/hris/pages/admin/overtime/overtimeRequests/create', '/hris/pages/admin/overtime/overtimeRequests/index', '/hris/pages/admin/overtime/overtimeRequests/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                    ]
                ],
                [
                    'text' => 'Employee Custom Fields',
                    'icon' => 'fas fa-fw fa-ruler-horizontal',
                    'submenu' => [
                        [
                            'text' => 'Field Names',
                            'icon' => 'fas fa-fw fa-ruler-horizontal',
                            'url' => '/hris/pages/admin/employee/employeeFieldNames/index',
                            'active' => ['/hris/pages/admin/employee/employeeFieldNames/create', '/hris/pages/admin/employee/employeeFieldNames/index', '/hris/pages/admin/employee/employeeFieldNames/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Custom Fields',
                            'icon' => 'fas fa-fw fa-ruler-horizontal',
                            'url' => '/hris/pages/admin/employee/employeeCustomFields/index',
                            'active' => ['/hris/pages/admin/employee/employeeCustomFields/create', '/hris/pages/admin/employee/employeeCustomFields/index', '/hris/pages/admin/employee/employeeCustomFields/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                    ]
                ],
                [
                    'text' => 'Company Loans',
                    'icon' => 'fas fa-fw fa-money-check',
                    'submenu' => [
                        [
                            'text' => 'Loan Types',
                            'icon' => 'fas fa-fw fa-money-check',
                            'url' => '/hris/pages/admin/loans/loanTypes/index',
                            'active' => ['/hris/pages/admin/loans/loanTypes/create', '/hris/pages/admin/loans/loanTypes/index', '/hris/pages/admin/loans/loanTypes/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Employee Loans',
                            'icon' => 'fas fa-fw fa-money-check',
                            'url' => '/hris/pages/admin/loans/employeeLoans/index',
                            'active' => ['/hris/pages/admin/loans/employeeLoans/create', '/hris/pages/admin/loans/employeeLoans/index', '/hris/pages/admin/loans/employeeLoans/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                    ]
                ],
                [
                    'text' => 'Company Assets',
                    'icon' => 'fas fa-fw fa-archive',
                    'submenu' => [
                        [
                            'text' => 'Asset Types',
                            'icon' => 'fas fa-fw fa-archive',
                            'url' => '/hris/pages/admin/assets/types/index',
                            'active' => ['/hris/pages/admin/assets/companyAssetTypes/create', '/hris/pages/admin/assets/companyAssetTypes/index', '/hris/pages/admin/assets/companyAssetTypes/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Assets',
                            'icon' => 'fas fa-fw fa-archive',
                            'url' => '/hris/pages/admin/assets/companyAssets/index',
                            'active' => ['/hris/pages/admin/assets/companyAssets/create', '/hris/pages/admin/assets/companyAssets/index', '/hris/pages/admin/assets/companyAssets/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Custom Fields',
                            'icon' => 'fas fa-fw fa-archive',
                            'url' => '/hris/pages/admin/assets/assetCustomFields/index',
                            'active' => ['/hris/pages/admin/assets/assetCustomFields/create', '/hris/pages/admin/assets/assetCustomFields/index', '/hris/pages/admin/assets/assetCustomFields/*/edit', 'regex:@^content/[0-9]+$@']
                        ]
                    ]
                ],
                [
                    'text' => 'Audit Log',
                    'icon' => 'fas fa-fw fa-compass',
                    'url' => '/hris/pages/admin/auditLog/index'
                ],
            ]
        ],
        'PERSONAL INFORMATION',
        [
            'text' => 'Personal Information',
            'icon' => 'fas fa-fw fa-grip-horizontal',
            'submenu' => [
                [
                    'text' => 'Dashboard',
                    'icon' => 'fas fa-fw fa-desktop',
                    'url' => '#'
                ],
                [
                    'text' => 'Basic Information',
                    'icon' => 'fas fa-fw fa-user',
                    'url' => '#'
                ],
                [
                    'text' => 'Qualifications',
                    'icon' => 'fas fa-fw fa-graduation-cap',
                    'submenu' => [
                        [
                            'text' => 'Skills',
                            'icon' => 'fas fa-fw fa-graduation-cap',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Education',
                            'icon' => 'fas fa-fw fa-graduation-cap',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Certifications',
                            'icon' => 'fas fa-fw fa-graduation-cap',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Languages',
                            'icon' => 'fas fa-fw fa-graduation-cap',
                            'url' => '#'
                        ],
                    ]
                ],
                [
                    'text' => 'Dependents',
                    'icon' => 'fas fa-fw fa-expand',
                    'url' => '#'
                ],
                [
                    'text' => 'Emergency Contacts',
                    'icon' => 'fas fa-fw fa-phone-square',
                    'url' => '#'
                ],
            ]
        ],
        'EMPLOYEE MANAGEMENT',
        [
            'text'    => 'Employees',
            'icon'    => 'fas fa-fw fa-users',
            'submenu' => [
                [
                    'text' => 'Employees',
                    'url'  => '/hris/pages/employees/employee/index',
                    'icon'    => 'fas fa-fw fa-users',
                ],
                [
                    'text' => 'Employee History',
                    'url'  => '/hris/pages/employee/employee_history/',
                    'icon'    => 'fas fa-fw fa-history',
                ],
                [
                    'text' => 'HR Form',
                    'url'  => '/hris/pages/employee/hr_form/',
                    'icon'    => 'fas fa-fw fa-folder',
                ],
                [
                    'text' => 'Itenerary Request',
                    'url'  => '/hris/pages/employee/itenerary_request/',
                    'icon'    => 'fas fa-fw fa-plane-departure',
                ],
                [
                    'text' => 'Monitor Attendance',
                    'url'  => '/hris/pages/employee/monitor_attendance/',
                    'icon'    => 'fas fa-fw fa-clock',
                ],
                [
                    'text' => 'Performance Review',
                    'url'  => '/hris/pages/employee/performance_review/',
                    'icon'    => 'fas fa-fw fa-chart-bar',
                ],
                [
                    'text' => 'Document Management',
                    'url'  => '/hris/pages/employee/document_management/',
                    'icon'    => 'fas fa-fw fa-file',
                ],
            ],
        ],
        'TIME MANAGEMENT',
        [
            'text' => 'Time Management',
            'icon' => 'fas fa-fw fa-hourglass-half',
            'url' => '#',
            'submenu' => [
                [
                    'text' => 'Work Shift Management',
                    'url' => '/hris/pages/time/workshiftManagement/index',
                    'icon' => 'fas fa-fw fa-clock'
                ],
                [
                    'text' => 'Work Shift Assignment',
                    'url' => '/hris/pages/time/workshiftAssignment/index',
                    'icon' => 'fas fa-fw fa-tasks'
                ],
                [
                    'text' => 'Attendance',
                    'url' => '/hris/pages/time/attendances/index',
                    'icon' => 'fas fa-fw fa-clock'
                ],
                [
                    'text' => 'Time Sheets',
                    'url' => '/hris/pages/time/timeSheets/index',
                    'icon' => 'fas fa-fw fa-stopwatch',
                ],
                [
                    'text' => 'Attendance Sheets',
                    'url' => '/hris/pages/time/attendanceSheets/index',
                    'icon' => 'fas fa-fw fa-calendar-check',
                ],
                [
                    'text' => 'Overtime Request',
                    'url' => '/hris/pages/time/overtimeRequests/index',
                    'icon' => 'fas fa-fw fa-calendar-plus',
                ],
            ]
        ],
        'LEAVE MANAGEMENT',
        [
            'text' => 'Leave Management',
            'icon' => 'fas fa-fw fa-share-alt',
            'submenu' => [
                [
                    'text' => 'Leave',
                    'icon' => 'fas fa-fw fa-calendar-day',
                    'submenu' => [
                        [
                            'text' => 'All My Leaves',
                            'icon' => 'fas fa-fw fa-calendar-day',
                            'url' => '/hris/pages/leaves/all/index',
                            'active' => ['/hris/pages/leaves/all/create', '/hris/pages/leaves/all/index', '/hris/pages/leaves/all/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Leave Entitlement',
                            'icon' => 'fas fa-fw fa-calendar-day',
                            'url' => '/hris/pages/leaves/leaveEntitlements/index',
                            'active' => ['/hris/pages/leaves/leaveEntitlements/create', '/hris/pages/leaves/leaveEntitlements/index', '/hris/pages/leaves/leaveEntitlements/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Approved Leave',
                            'icon' => 'fas fa-fw fa-calendar-day',
                            'url' => '/hris/pages/leaves/approvedLeaves/index',
                            'active' => ['/hris/pages/leaves/approvedLeaves/create', '/hris/pages/leaves/approvedLeaves/index', '/hris/pages/leaves/approvedLeaves/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Pending Leave',
                            'icon' => 'fas fa-fw fa-calendar-day',
                            'url' => '/hris/pages/leaves/pendingLeaves/index',
                            'active' => ['/hris/pages/leaves/pendingLeaves/create', '/hris/pages/leaves/pendingLeaves/index', '/hris/pages/leaves/pendingLeaves/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Subordinate Leave',
                            'icon' => 'fas fa-fw fa-calendar-day',
                            'url' => '/hris/pages/leaves/subordinateLeaves/index',
                            'active' => ['/hris/pages/leaves/subordinateLeaves/create', '/hris/pages/leaves/subordinateLeaves/index', '/hris/pages/leaves/subordinateLeaves/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Cancellation Requests',
                            'icon' => 'fas fa-fw fa-calendar-day',
                            'url' => '/hris/pages/leaves/cancellationRequests/index',
                            'active' => ['/hris/pages/leaves/cancellationRequests/create', '/hris/pages/leaves/cancellationRequests/index', '/hris/pages/leaves/cancellationRequests/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Approval Requests',
                            'icon' => 'fas fa-fw fa-calendar-day',
                            'url' => '/hris/pages/leaves/approvalRequests/index',
                            'active' => ['/hris/pages/leaves/approvalRequests/create', '/hris/pages/leaves/approvalRequests/index', '/hris/pages/leaves/approvalRequests/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                    ]
                ],
                [
                    'text' => 'Leave Calendar',
                    'icon' => 'fas fa-fw fa-calendar-alt',
                    'url' => '/hris/pages/leaves/calendar/index'
                ]
            ]
        ],
        'RECRUITMENT MANAGEMENT',
        [
            'text'    => 'Recruitment',
            'icon' => 'fas fa-fw fa-th',
            'submenu' => [
                [
                    'text'    => 'Recruitment Setup',
                    'url'     => '#',
                    'icon'    => 'fas fa-fw fa-random',
                    'submenu' => [
                        [
                            'text'    => 'Benefits',
                            'url'     => '/hris/pages/recruitment/recruitmentSetup/benefits/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/benefits/create', '/hris/pages/recruitment/recruitmentSetup/benefits/index', '/hris/pages/recruitment/recruitmentSetup/benefits/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Education Levels',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/educationLevels/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/educationLevels/create', '/hris/pages/recruitment/recruitmentSetup/educationLevels/index', '/hris/pages/recruitment/recruitmentSetup/educationLevels/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Employment Types',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/employmentTypes/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/employmentTypes/create', '/hris/pages/recruitment/recruitmentSetup/employmentTypes/index', '/hris/pages/recruitment/recruitmentSetup/employmentTypes/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Experience Levels',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/experienceLevels/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/experienceLevels/create', '/hris/pages/recruitment/recruitmentSetup/experienceLevels/index', '/hris/pages/recruitment/recruitmentSetup/experienceLevels/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                        [
                            'text' => 'Job Functions',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/jobFunctions/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/jobFunctions/create', '/hris/pages/recruitment/recruitmentSetup/jobFunctions/index', '/hris/pages/recruitment/recruitmentSetup/jobFunctions/*/edit', 'regex:@^content/[0-9]+$@']
                        ],
                    ],
                ],
                [
                    'text' => 'Job Positions',
                    'url'  => '/hris/pages/recruitment/jobPositions/index',
                    'icon' => 'fas fa-fw fa-columns',
                    'active' => ['/hris/pages/recruitment/jobPositions/create', '/hris/pages/recruitment/jobPositions/index', '/hris/pages/recruitment/jobPositions/*/edit', 'regex:@^content/[0-9]+$@']
                ],
                [
                    'text' => 'Candidates',
                    'url'  => '/hris/pages/recruitment/candidates/index',
                    'icon' => 'fas fa-fw fa-user-friends',
                    'active' => ['/hris/pages/recruitment/candidates/create', '/hris/pages/recruitment/candidates/index', '/hris/pages/recruitment/candidates/*/edit', 'regex:@^content/[0-9]+$@']
                ],
            ],
        ],
        'ADMIN REPORTS',
        [
            'text' => 'Admin Reports',
            'icon' => 'fas fa-fw fa-window-maximize',
            'url' => '#'
        ],
        [
            'text' => 'Report Files',
            'icon' => 'fas fa-fw fa-file-export',
            'url' => '#'
        ],
        'SYSTEM MANAGEMENT',
        [
            'text' => 'System',
            'icon' => 'fas fa-fw fa-sliders-h',
            'submenu' => [
                [
                    'text' => 'Settings',
                    'icon' => 'fas fa-fw fa-cogs',
                    'submenu' => [
                        [
                            'text' => 'Company',
                            'icon' => 'fas fa-fw fa-cogs',
                            'url' => '#'
                        ],
                        [
                            'text' => 'System',
                            'icon' => 'fas fa-fw fa-cogs',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Email',
                            'icon' => 'fas fa-fw fa-cogs',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Leave / PTO',
                            'icon' => 'fas fa-fw fa-cogs',
                            'url' => '#'
                        ],
                        [
                            'text' => 'LDAP',
                            'icon' => 'fas fa-fw fa-cogs',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Attendance',
                            'icon' => 'fas fa-fw fa-cogs',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Other',
                            'icon' => 'fas fa-fw fa-cogs',
                            'url' => '#'
                        ],
                    ]
                ],
                [
                    'text' => 'Users',
                    'icon' => 'fas fa-fw fa-user',
                    'submenu' => [
                        [
                            'text' => 'Users',
                            'icon' => 'fas fa-fw fa-user',
                            'url' => '#'
                        ],
                        [
                            'text' => 'User Roles',
                            'icon' => 'fas fa-fw fa-user',
                            'url' => '#'
                        ],
                    ]
                ],
                [
                    'text' => 'Manage Modules',
                    'icon' => 'fas fa-fw fa-folder-open',
                    'submenu' => [
                        [
                            'text' => 'Usage',
                            'icon' => 'fas fa-fw fa-folder-open',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Modules',
                            'icon' => 'fas fa-fw fa-folder-open',
                            'url' => '#'
                        ],
                    ]
                ],
                [
                    'text' => 'Manage Permissions',
                    'icon' => 'fas fa-fw fa-unlock',
                    'url' => '#'
                ],
                [
                    'text' => 'Manage Metadeta',
                    'icon' => 'fas fa-fw fa-microchip',
                    'submenu' => [
                        [
                            'text' => 'Countries',
                            'icon' => 'fas fa-fw fa-microchip',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Provinces',
                            'icon' => 'fas fa-fw fa-microchip',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Currency Types',
                            'icon' => 'fas fa-fw fa-microchip',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Nationality',
                            'icon' => 'fas fa-fw fa-microchip',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Ethnicity',
                            'icon' => 'fas fa-fw fa-microchip',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Immigration Status',
                            'icon' => 'fas fa-fw fa-microchip',
                            'url' => '#'
                        ],
                    ]
                ],
                [
                    'text' => 'Data',
                    'icon' => 'fas fa-fw fa-database',
                    'submenu' => [
                        [
                            'text' => 'Data Importers',
                            'icon' => 'fas fa-fw fa-database',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Data Import Files',
                            'icon' => 'fas fa-fw fa-database',
                            'url' => '#'
                        ],
                    ]
                ],
            ]
        ],
        'INSIGHTS',
        [
            'text' => 'Time and Management',
            'icon' => 'fas fa-fw fa-user-clock',
            'url' => '#'
        ],
        'PAYROLL',
        [
            'text' => 'Salary',
            'icon' => 'fas fa-fw fa-file-archive',
            'submenu' => [
                [
                    'text' => 'Salary Component Types',
                    'icon' => 'fas fa-fw fa-money-check-alt',
                    'url' => '#'
                ],
                [
                    'text' => 'Salary Components',
                    'icon' => 'fas fa-fw fa-money-check-alt',
                    'url' => '#'
                ],
                [
                    'text' => 'Employee Salary Components',
                    'icon' => 'fas fa-fw fa-money-check-alt',
                    'url' => '#'
                ],
            ]
        ],
        [
            'text' => 'Payroll Reports',
            'icon' => 'fas fa-fw fa-cogs',
            'submenu' => [
                [
                    'text' => 'Company Payroll',
                    'icon' => 'fas fa-fw fa-cogs',
                    'url' => '#'
                ],
                [
                    'text' => 'Payroll Reports',
                    'icon' => 'fas fa-fw fa-cogs',
                    'url' => '#'
                ],
                [
                    'text' => 'Payroll Columns',
                    'icon' => 'fas fa-fw fa-cogs',
                    'url' => '#'
                ],
                [
                    'text' => 'Calculation Groups',
                    'icon' => 'fas fa-fw fa-cogs',
                    'url' => '#'
                ],
                [
                    'text' => 'Calculation Methods',
                    'icon' => 'fas fa-fw fa-cogs',
                    'url' => '#'
                ],
                [
                    'text' => 'Payslip Templates',
                    'icon' => 'fas fa-fw fa-cogs',
                    'url' => '#'
                ],
            ]
        ],
        'DOCUMENT MANAGEMENT',
        [
            'text' => 'Documents',
            'icon' => 'fas fa-fw fa-file-alt',
            'submenu' => [
                [
                    'text' => 'My Documents',
                    'icon' => 'fas fa-fw fa-file',
                    'submenu' => [
                        [
                            'text' => 'Company Documents',
                            'icon' => 'fas fa-fw fa-file',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Personal Documents',
                            'icon' => 'fas fa-fw fa-file',
                            'url' => '#'
                        ],
                    ]
                ],
                [
                    'text' => 'HR Forms',
                    'icon' => 'fas fa-fw fa-file-word',
                    'url' => '#'
                ],
            ]
        ],
        'COMPANY',
        [
            'text' => 'Staff Directory',
            'icon' => 'fas fa-fw fa-user',
            'url' => '#'
        ],
        'TRAINING MANAGEMENT',
        [
            'text' => 'Training',
            'icon' => 'fas fa-fw fa-briefcase',
            'submenu' => [
                [
                    'text' => 'My Training Sessions',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'url' => '#'
                ],
                [
                    'text' => 'All Training Sessions',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'url' => '#'
                ],
                [
                    'text' => 'Training Sessions of Direct Reports',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'url' => '#'
                ],
                [
                    'text' => 'Training Sessions Coordinated by Me',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'url' => '#'
                ],
            ]
        ],
        'PERFORMANCE',
        [
            'text' => 'Reviews',
            'icon' => 'fas fa-fw fa-bezier-curve',
            'submenu' => [
                [
                    'text' => 'Self Assessments',
                    'icon' => 'fas fa-fw fa-compress-arrows-alt',
                    'url' => '#'
                ],
                [
                    'text' => 'Performance Reviews Coordinated by Me',
                    'icon' => 'fas fa-fw fa-compress-arrows-alt',
                    'url' => '#'
                ],
                [
                    'text' => 'Provide Feedback',
                    'icon' => 'fas fa-fw fa-compress-arrows-alt',
                    'url' => '#'
                ],
            ]
        ],
        'TRAVEL MANAGEMENT',
        [
            'text' => 'Itinerary',
            'icon' => 'fas fa-fw fa-globe',
            'submenu' => [
                [
                    'text' => 'Travel Requests',
                    'icon' => 'fas fa-fw fa-plane-departure',
                    'url' => '#'
                ],
                [
                    'text' => 'Subordinate Travel Requests',
                    'icon' => 'fas fa-fw fa-plane-departure',
                    'url' => '#'
                ],
                [
                    'text' => 'Travel Request Approval',
                    'icon' => 'fas fa-fw fa-plane-departure',
                    'url' => '#'
                ],
            ]
        ],
        'FINANCE MANAGEMENT',
        [
            'text' => 'Finance',
            'icon' => 'fas fa-fw fa-calculator',
            'submenu' => [
                [
                    'text' => 'Benefits',
                    'icon' => 'fas fa-fw fa-bars',
                    'submenu' => [
                        [
                            'text' => 'Expenses',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Subordinate Expenses',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Expenses Approval',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '#'
                        ],
                    ]
                ],
                [
                    'text' => 'Salary',
                    'icon' => 'fas fa-fw fa-calculator',
                    'url' => '#'
                ],
                [
                    'text' => 'Loans',
                    'icon' => 'fas fa-fw fa-money-check',
                    'url' => '#'
                ],
            ]
        ],
        'USER REPORTS',
        [
            'text' => 'Reports',
            'icon' => 'fas fa-fw fa-window-maximize',
            'url' => '#'
        ],
        [
            'text' => 'Reports Files',
            'icon' => 'fas fa-fw fa-file-export',
            'url' => '#'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Daterangepicker',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/orange/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
