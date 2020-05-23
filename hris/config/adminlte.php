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
    'classes_sidebar' => 'sidebar-light-primary',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand-md',
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
            'url' => 'admin/pages',
            'icon' => 'fas fa-fw fa-file'
        ],
        'ADMINISTRATION',
        [
            'text' => 'Admin',
            'icon' => 'fas fa-fw fa-cubes',
            'icon_color' => 'cyan',
            'submenu' => [
                [   
                    'text' => 'Company Structure',
                    'icon' => 'fas fa-fw fa-building',
                    'url' => '/pages/admin/company/index',
                    'icon_color' => 'cyan',
                ],
                [
                    'text' => 'Job Details Setup',
                    'icon' => 'fas fa-fw fa-columns',
                    'icon_color' => 'cyan',
                    'submenu' => [
                        [
                            'text' => 'Job Titles',
                            'icon' => 'fas fa-fw fa-columns',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/jobDetails/jobTitles/index'
                        ],
                        [
                            'text' => 'Pay Grades',
                            'icon' => 'fas fa-fw fa-columns',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/jobDetails/payGrades/index'
                        ],
                        [
                            'text' => 'Employment Status',
                            'icon' => 'fas fa-fw fa-columns',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/jobDetails/employmentStatuses/index'
                        ],
                    ]
                ],
                [
                    'text' => 'Qualifications Setup',
                    'icon' => 'fas fa-fw fa-check-square',
                    'icon_color' => 'cyan',
                    'submenu' => [
                        [
                            'text' => 'Skills',
                            'icon' => 'fas fa-fw fa-check-square',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/qualifications/skills/index'
                        ],
                        [
                            'text' => 'Education',
                            'icon' => 'fas fa-fw fa-check-square',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/qualifications/educations/index'
                        ],
                        [
                            'text' => 'Certifications',
                            'icon' => 'fas fa-fw fa-check-square',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/qualifications/certifications/index'
                        ],
                        [
                            'text' => 'Languages',
                            'icon' => 'fas fa-fw fa-check-square',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/qualifications/languages/index'
                        ]
                    ]
                ],
                [
                    'text' => 'Training Setup',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'icon_color' => 'cyan',
                    'submenu' => [
                        [
                            'text' => 'Courses',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/training/courses/index'
                        ],
                        [
                            'text' => 'Training Sessions',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/training/trainingSessions/index'
                        ],
                        [
                            'text' => 'Employee Training Sessions',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'icon_color' => 'teal',
                            'url' => '/pages/admin/training/employeeTrainingSessions/index'
                        ]
                    ]
                ]
            ]
        ],
        'EMPLOYEE MANAGEMENT',
        [
            'text'    => 'Employees',
            'icon'    => 'fas fa-fw fa-users',
            'icon_color' => 'indigo',
            'submenu' => [
                [
                    'text' => 'Employees',
                    'url'  => '/pages/employees/employee/',
                    'icon'    => 'fas fa-fw fa-users',
                    'icon_color' => 'indigo',
                ],
                [
                    'text' => 'Employee History',
                    'url'  => '/pages/employee/employee_history/',
                    'icon'    => 'fas fa-fw fa-history',
                    'icon_color' => 'indigo',
                ],
                [
                    'text' => 'HR Form',
                    'url'  => '/pages/employee/hr_form/',
                    'icon'    => 'fas fa-fw fa-folder',
                    'icon_color' => 'indigo',
                ],
                [
                    'text' => 'Itenerary Request',
                    'url'  => '/pages/employee/itenerary_request/',
                    'icon'    => 'fas fa-fw fa-plane-departure',
                    'icon_color' => 'indigo',
                ],
                [
                    'text' => 'Monitor Attendance',
                    'url'  => '/pages/employee/monitor_attendance/',
                    'icon'    => 'fas fa-fw fa-clock',
                    'icon_color' => 'indigo',
                ],
                [
                    'text' => 'Performance Review',
                    'url'  => '/pages/employee/performance_review/',
                    'icon'    => 'fas fa-fw fa-chart-bar',
                    'icon_color' => 'indigo',
                ],
                [
                    'text' => 'Document Management',
                    'url'  => '/pages/employee/document_management/',
                    'icon'    => 'fas fa-fw fa-file',
                    'icon_color' => 'indigo',
                ],
            ],
        ],
        'RECRUITMENT MANAGEMENT',
        [
            'text'    => 'Recruitment',
            'icon' => 'fas fa-fw fa-th',
            'icon_color' => 'red',
            'submenu' => [
                [
                    'text'    => 'Recruitment Setup',
                    'url'     => '#',
                    'icon'    => 'fas fa-fw fa-random',
                    'icon_color' => 'red',
                    'submenu' => [
                        [
                            'text'    => 'Benefits',
                            'url'     => '/pages/recruitment/recruitmentSetup/benefits/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'icon_color' => 'orange',
                        ],
                        [
                            'text' => 'Education Levels',
                            'url'  => '/pages/recruitment/recruitmentSetup/educationLevels/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'icon_color' => 'orange',
                        ],
                        [
                            'text' => 'Employment Types',
                            'url'  => '/pages/recruitment/recruitmentSetup/employmentTypes/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'icon_color' => 'orange',
                        ],
                        [
                            'text' => 'Experience Levels',
                            'url'  => '/pages/recruitment/recruitmentSetup/experienceLevels/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'icon_color' => 'orange',
                        ],
                        [
                            'text' => 'Job Functions',
                            'url'  => '/pages/recruitment/recruitmentSetup/jobFunctions/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'icon_color' => 'orange',
                        ],
                    ],
                ],
                [
                    'text' => 'Job Positions',
                    'url'  => '/pages/recruitment/jobPositions/index',
                    'icon' => 'fas fa-fw fa-columns',
                    'icon_color' => 'red',
                ],
                [
                    'text' => 'Candidates',
                    'url'  => '/pages/recruitment/candidates/index',
                    'icon' => 'fas fa-fw fa-user-friends',
                    'icon_color' => 'red',
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
