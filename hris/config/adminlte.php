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

    'title' => 'AdminLTE 3',
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

    'logo' => '<b>Admin</b>LTE',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-1',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AdminLTE',

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
        'MAIN NAVIGATION',
        [
            'text' => 'Pages',
            'url' => 'admin/hris/pages',
            'icon' => 'fas fa-fw fa-file'
        ],
        'ADMINISTRATION',
        [
            'text' => 'Admin',
            'icon' => 'fas fa-fw fa-cubes',
            'submenu' => [
                [   
                    'text' => 'Company Structure',
                    'icon' => 'fas fa-fw fa-building',
                    'url' => '/hris/pages/admin/company/index',
                ],
                [
                    'text' => 'Job Details Setup',
                    'icon' => 'fas fa-fw fa-columns',
                    'submenu' => [
                        [
                            'text' => 'Job Titles',
                            'icon' => 'fas fa-fw fa-columns',
                            'url' => '/hris/pages/admin/jobDetails/jobTitles/index'
                        ],
                        [
                            'text' => 'Pay Grades',
                            'icon' => 'fas fa-fw fa-columns',
                            'url' => '/hris/pages/admin/jobDetails/payGrades/index'
                        ],
                        [
                            'text' => 'Employment Status',
                            'icon' => 'fas fa-fw fa-columns',
                            'url' => '/hris/pages/admin/jobDetails/employmentStatuses/index'
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
                            'url' => '/hris/pages/admin/qualifications/skills/index'
                        ],
                        [
                            'text' => 'Education',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/educations/index'
                        ],
                        [
                            'text' => 'Certifications',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/certifications/index'
                        ],
                        [
                            'text' => 'Languages',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/languages/index'
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
                            'url' => '/hris/pages/admin/training/courses/index'
                        ],
                        [
                            'text' => 'Training Sessions',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'url' => '/hris/pages/admin/training/trainingSessions/index'
                        ],
                        [
                            'text' => 'Employee Training Sessions',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'url' => '/hris/pages/admin/training/employeeTrainingSessions/index'
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
                            'url' => '/hris/pages/admin/properties/clients/index'
                        ],
                        [
                            'text' => 'Projects',
                            'icon' => 'fas fa-fw fa-list-alt',
                            'url' => '/hris/pages/admin/properties/projects/index'
                        ],
                        [
                            'text' => 'Employee Projects',
                            'icon' => 'fas fa-fw fa-list-alt',
                            'url' => '/hris/pages/admin/properties/employeeProjects/index'
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
                            'url' => '/hris/pages/admin/benefits/expensesCategories/index'
                        ],
                        [
                            'text' => 'Payment Methods',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '/hris/pages/admin/benefits/paymentMethods/index'
                        ],
                        [
                            'text' => 'Employee Expenses',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '/hris/pages/admin/benefits/employeeExpenses/index'
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
                    'url'  => '/hris/pages/employees/employee/',
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
                        ],
                        [
                            'text' => 'Education Levels',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/educationLevels/index',
                            'icon'    => 'fas fa-fw fa-random',
                        ],
                        [
                            'text' => 'Employment Types',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/employmentTypes/index',
                            'icon'    => 'fas fa-fw fa-random',
                        ],
                        [
                            'text' => 'Experience Levels',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/experienceLevels/index',
                            'icon'    => 'fas fa-fw fa-random',
                        ],
                        [
                            'text' => 'Job Functions',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/jobFunctions/index',
                            'icon'    => 'fas fa-fw fa-random',
                        ],
                    ],
                ],
                [
                    'text' => 'Job Positions',
                    'url'  => '/hris/pages/recruitment/jobPositions/index',
                    'icon' => 'fas fa-fw fa-columns',
                ],
                [
                    'text' => 'Candidates',
                    'url'  => '/hris/pages/recruitment/candidates/index',
                    'icon' => 'fas fa-fw fa-user-friends',
                ],
            ],
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
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
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
