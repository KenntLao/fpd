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

    'title' => 'NEXU - HRIS',
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

    'logo' => '<b>Nexus </b>HRIS',
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
                ]
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
        'TIME MANAGEMENT',
        [
            'text' => 'Time Management',
            'icon' => 'fas fa-fw fa-hourglass-half',
            'url' => '#',
            'submenu' => [
                [
                    'text' => 'Projects',
                    'url' => '/hris/pages/time/timeProjects/index',
                    'icon' => 'fas fa-fw fa-project-diagram',
                    'active' => ['/hris/pages/time/timeProjects/create', '/hris/pages/time/timeProjects/index', '/hris/pages/time/timeProjects/*/edit', 'regex:@^content/[0-9]+$@']
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
        ]
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
