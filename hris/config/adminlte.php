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
    'logo_img' => '../public/assets/images/logo.jpg',
    'logo_img_class' => 'logo-img',
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
    'layout_fixed_sidebar' => false,
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

    'dashboard_url' => 'hris',

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
        [
            'header' => 'ADMINISTRATION',
            'can' => ['company-structure', 'job-title', 'pay-grade', 'employment-status', 'skill', 'education', 'certification','language', 'course', 'training-session', 'employee-training-session', 'client', 'project', 'employee-project', 'leave-type', 'leave-period', 'work-week', 'holiday', 'leave-rule', 'paid-time-off', 'leave-group','leave-group-employee', 'employee-leave-list', 'expense-category','payment-method','employee-expense', 'overtime-category', 'loan-type','employee-loan', 'company-asset-type','company-asset', 'audit-log']
        ],
        [
            'text' => 'Admin',
            'icon' => 'fas fa-fw fa-cubes',
            'can' => ['company-structure', 'job-title', 'pay-grade', 'employment-status', 'skill', 'education', 'certification','language', 'course', 'training-session', 'employee-training-session', 'client', 'project', 'employee-project', 'leave-type', 'leave-period', 'work-week', 'holiday', 'leave-rule', 'paid-time-off', 'leave-group','leave-group-employee', 'employee-leave-list', 'expense-category','payment-method','employee-expense', 'overtime-category', 'loan-type','employee-loan', 'company-asset-type','company-asset', 'audit-log'],
            'submenu' => [
                [   
                    'text' => 'Company Structure',
                    'icon' => 'fas fa-fw fa-building',
                    'url' => '/hris/pages/admin/company/index',
                    'active' => ['/hris/pages/admin/company/create', '/hris/pages/admin/company/index', '/hris/pages/admin/company/*/edit', 'regex:@^content/[0-9]+$@'],
                    'can' => 'company-structure',
                ],
                [
                    'text' => 'Job Details Setup',
                    'icon' => 'fas fa-fw fa-columns',
                    'can' => ['job-title','pay-grade','employment-status'],
                    'submenu' => [
                        [
                            'text' => 'Job Titles',
                            'icon' => 'fas fa-fw fa-columns',
                            'url' => '/hris/pages/admin/jobDetails/jobTitles/index',
                            'active' => ['/hris/pages/admin/jobDetails/jobTitles/create', '/hris/pages/admin/jobDetails/jobTitles/index', '/hris/pages/admin/jobDetails/jobTitles/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'job-title',
                        ],
                        [
                            'text' => 'Pay Grades',
                            'icon' => 'fas fa-fw fa-columns',
                            'url' => '/hris/pages/admin/jobDetails/payGrades/index',
                            'active' => ['/hris/pages/admin/jobDetails/payGrades/create', '/hris/pages/admin/jobDetails/payGrades/index', '/hris/pages/admin/jobDetails/payGrades/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'pay-grade',
                        ],
                        [
                            'text' => 'Employment Status',
                            'icon' => 'fas fa-fw fa-columns',
                            'url' => '/hris/pages/admin/jobDetails/employmentStatuses/index',
                            'active' => ['/hris/pages/admin/jobDetails/employmentStatuses/create', '/hris/pages/admin/jobDetails/employmentStatuses/index', '/hris/pages/admin/jobDetails/employmentStatuses/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employment-status',
                        ],
                    ]
                ],
                [
                    'text' => 'Qualifications Setup',
                    'icon' => 'fas fa-fw fa-check-square',
                    'can' => ['skill','education','certification','language'],
                    'submenu' => [
                        [
                            'text' => 'Skills',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/skills/index',
                            'active' => ['/hris/pages/admin/qualifications/skills/create', '/hris/pages/admin/qualifications/skills/index', '/hris/pages/admin/qualifications/skills/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'skill',
                        ],
                        [
                            'text' => 'Education',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/educations/index',
                            'active' => ['/hris/pages/admin/qualifications/educations/create', '/hris/pages/admin/qualifications/educations/index', '/hris/pages/admin/qualifications/educations/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'education',
                        ],
                        [
                            'text' => 'Certifications',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/certifications/index',
                            'active' => ['/hris/pages/admin/qualifications/certifications/create', '/hris/pages/admin/qualifications/certifications/index', '/hris/pages/admin/qualifications/certifications/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'certification',
                        ],
                        [
                            'text' => 'Languages',
                            'icon' => 'fas fa-fw fa-check-square',
                            'url' => '/hris/pages/admin/qualifications/languages/index',
                            'active' => ['/hris/pages/admin/qualifications/languages/create', '/hris/pages/admin/qualifications/languages/index', '/hris/pages/admin/qualifications/languages/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'language',
                        ]
                    ]
                ],
                [
                    'text' => 'Training Setup',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'can' => ['course','training-session','employee-training-session'],
                    'submenu' => [
                        [
                            'text' => 'Courses',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'url' => '/hris/pages/admin/training/courses/index',
                            'active' => ['/hris/pages/admin/training/courses/create', '/hris/pages/admin/training/courses/index', '/hris/pages/admin/training/courses/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'course',
                        ],
                        [
                            'text' => 'Training Sessions',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'url' => '/hris/pages/admin/training/trainingSessions/index',
                            'active' => ['/hris/pages/admin/training/trainingSessions/create', '/hris/pages/admin/training/trainingSessions/index', '/hris/pages/admin/training/trainingSessions/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'training-session',
                        ],
                        [
                            'text' => 'Employee Training Sessions',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'url' => '/hris/pages/admin/training/employeeTrainingSessions/index',
                            'active' => ['/hris/pages/admin/training/employeeTrainingSessions/create', '/hris/pages/admin/training/employeeTrainingSessions/index', '/hris/pages/admin/training/employeeTrainingSessions/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-training-session',
                        ]
                    ]
                ],
                [
                    'text' => 'Properties Setup',
                    'icon' => 'fas fa-fw fa-list-alt',
                    'can' => ['client','project','employee-project'],
                    'submenu' => [
                        [
                            'text' => 'Clients',
                            'icon' => 'fas fa-fw fa-list-alt',
                            'url' => '/hris/pages/admin/properties/clients/index',
                            'active' => ['/hris/pages/admin/properties/clients/create', '/hris/pages/admin/properties/clients/index', '/hris/pages/admin/properties/clients/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'client',
                        ],
                        [
                            'text' => 'Projects',
                            'icon' => 'fas fa-fw fa-list-alt',
                            'url' => '/hris/pages/admin/properties/projects/index',
                            'active' => ['/hris/pages/admin/properties/projects/create', '/hris/pages/admin/properties/projects/index', '/hris/pages/admin/training/properties/projects/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'project',
                        ],
                        [
                            'text' => 'Employee Projects',
                            'icon' => 'fas fa-fw fa-list-alt',
                            'url' => '/hris/pages/admin/properties/employeeProjects/index',
                            'active' => ['/hris/pages/admin/properties/employeeProjects/create', '/hris/pages/admin/properties/employeeProjects/index', '/hris/pages/admin/properties/employeeProjects/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-project',
                        ]
                    ]
                ],
                [
                    'text' => 'Leave Settings',
                    'icon' => 'fas fa-fw fa-pause',
                    'can' => ['leave-type','leave-period','work-week','holiday','leave-rule','paid-time-off','leave-group','leave-group-employee','employee-leave-list'],
                    'submenu' => [
                        [
                            'text' => 'Leave Types',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leaveTypes/index',
                            'active' => ['/hris/pages/admin/leave/leaveTypes/create', '/hris/pages/admin/leave/leaveTypes/index', '/hris/pages/admin/leave/leaveTypes/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'leave-type',
                        ],
                        [
                            'text' => 'Leave Period',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leavePeriods/index',
                            'active' => ['/hris/pages/admin/leave/leavePeriods/create', '/hris/pages/admin/leave/leavePeriods/index', '/hris/pages/admin/leave/leavePeriods/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'leave-period',
                        ],
                        [
                            'text' => 'Work Week',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/workWeeks/index',
                            'active' => ['/hris/pages/admin/leave/workWeeks/create', '/hris/pages/admin/leave/workWeeks/index', '/hris/pages/admin/leave/workWeeks/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'work-week',
                        ],
                        [
                            'text' => 'Holidays',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/holidays/index',
                            'active' => ['/hris/pages/admin/leave/holidays/create', '/hris/pages/admin/leave/holidays/index', '/hris/pages/admin/leave/holidays/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'holiday',
                        ],
                        [
                            'text' => 'Leave Rules',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leaveRules/index',
                            'active' => ['/hris/pages/admin/leave/leaveRules/create', '/hris/pages/admin/leave/leaveRules/index', '/hris/pages/admin/leave/leaveRules/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'leave-rule',
                        ],
                        [
                            'text' => 'Paid Time Off',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/paidTimeOffs/index',
                            'active' => ['/hris/pages/admin/leave/paidTimeOffs/create', '/hris/pages/admin/leave/paidTimeOffs/index', '/hris/pages/admin/leave/paidTimeOffs/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'paid-time-off',
                        ],
                        [
                            'text' => 'Leave Groups',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leaveGroups/index',
                            'active' => ['/hris/pages/admin/leave/leaveGroups/create', '/hris/pages/admin/leave/leaveGroups/index', '/hris/pages/admin/leave/leaveGroups/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'leave-group',
                        ],
                        [
                            'text' => 'Leave Group Employee',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/leaveGroupEmployees/index',
                            'active' => ['/hris/pages/admin/leave/leaveGroupEmployees/create', '/hris/pages/admin/leave/leaveGroupEmployees/index', '/hris/pages/admin/leave/leaveGroupEmployees/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'leave-group-employee',
                        ],
                        [
                            'text' => 'Employee Leave List',
                            'icon' => 'fas fa-fw fa-pause',
                            'url' => '/hris/pages/admin/leave/employeeLeaveList/index',
                            'active' => ['/hris/pages/admin/leave/employeeLeaveList/create', '/hris/pages/admin/leave/employeeLeaveList/index', '/hris/pages/admin/leave/employeeLeaveList/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-leave-list',
                        ]
                    ]
                ],
                [
                    'text' => 'Benefits Administration',
                    'icon' => 'fas fa-fw fa-bars',
                    'can' => ['expense-category','payment-method','employee-expense'],
                    'submenu' => [
                        [
                            'text' => 'Expenses Categories',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '/hris/pages/admin/benefits/expensesCategories/index',
                            'active' => ['/hris/pages/admin/benefits/expensesCategories/create', '/hris/pages/admin/benefits/expensesCategories/index', '/hris/pages/admin/benefits/expensesCategories/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'expense-category',
                        ],
                        [
                            'text' => 'Payment Methods',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '/hris/pages/admin/benefits/paymentMethods/index',
                            'active' => ['/hris/pages/admin/benefits/paymentMethods/create', '/hris/pages/admin/benefits/paymentMethods/index', '/hris/pages/admin/benefits/paymentMethods/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'payment-method',
                        ],
                        [
                            'text' => 'Employee Expenses',
                            'icon' => 'fas fa-fw fa-bars',
                            'url' => '/hris/pages/admin/benefits/employeeExpenses/index',
                            'active' => ['/hris/pages/admin/benefits/employeeExpenses/create', '/hris/pages/admin/benefits/employeeExpenses/index', '/hris/pages/admin/benefits/employeeExpenses/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-expense',
                        ]
                    ]
                ],
                [
                    'text' => 'Overtime Administration',
                    'icon' => 'fas fa-fw fa-align-center',
                    'can' => 'overtime-category',
                    'submenu' => [
                        [
                            'text' => 'Categories',
                            'icon' => 'fas fa-fw fa-align-center',
                            'url' => '/hris/pages/admin/overtime/overtimeCategories/index',
                            'active' => ['/hris/pages/admin/overtime/overtimeCategories/create', '/hris/pages/admin/overtime/overtimeCategories/index', '/hris/pages/admin/overtime/overtimeCategories/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'overtime-category',
                        ]
                    ]
                ],
                [
                    'text' => 'Company Loans',
                    'icon' => 'fas fa-fw fa-money-check',
                    'can' => ['loan-type','employee-loan'],
                    'submenu' => [
                        [
                            'text' => 'Loan Types',
                            'icon' => 'fas fa-fw fa-money-check',
                            'url' => '/hris/pages/admin/loans/loanTypes/index',
                            'active' => ['/hris/pages/admin/loans/loanTypes/create', '/hris/pages/admin/loans/loanTypes/index', '/hris/pages/admin/loans/loanTypes/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'loan-type',
                        ],
                        [
                            'text' => 'Employee Loans',
                            'icon' => 'fas fa-fw fa-money-check',
                            'url' => '/hris/pages/admin/loans/employeeLoans/index',
                            'active' => ['/hris/pages/admin/loans/employeeLoans/create', '/hris/pages/admin/loans/employeeLoans/index', '/hris/pages/admin/loans/employeeLoans/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-loan',
                        ],
                    ]
                ],
                [
                    'text' => 'Company Assets',
                    'icon' => 'fas fa-fw fa-archive',
                    'can' => ['company-asset-type','company-asset'],
                    'submenu' => [
                        [
                            'text' => 'Asset Types',
                            'icon' => 'fas fa-fw fa-archive',
                            'url' => '/hris/pages/admin/companyAssets/types/index',
                            'active' => ['/hris/pages/admin/companyAssets/types/create', '/hris/pages/admin/companyAssets/types/index', '/hris/pages/admin/companyAssets/types/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'company-asset-type',
                        ],
                        [
                            'text' => 'Assets',
                            'icon' => 'fas fa-fw fa-archive',
                            'url' => '/hris/pages/admin/companyAssets/assets/index',
                            'active' => ['/hris/pages/admin/companyAssets/assets/create', '/hris/pages/admin/companyAssets/assets/index', '/hris/pages/admin/companyAssets/assets/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'company-asset',
                        ],
                    ]
                ],
                [
                    'text' => 'Audit Log',
                    'icon' => 'fas fa-fw fa-compass',
                    'url' => '/hris/pages/admin/auditLog/index',
                    'can' => 'audit-log',
                ]
            ]
        ],
        [
            'header' => 'PERSONAL INFORMATION'
        ],
        [
            'text' => 'Personal Information',
            'icon' => 'fas fa-fw fa-grip-horizontal',
            'submenu' => [
                [
                    'text' => 'Dashboard',
                    'icon' => 'fas fa-fw fa-desktop',
                    'url' => '/hris/',
                    'active' => ['/hris/', 'regex:@^content/[0-9]+$@'],
                ],
                [
                    'text' => 'Basic Information',
                    'icon' => 'fas fa-fw fa-user',
                    'url' => '/hris/pages/personalInformation/profile/index'
                ],
                [
                    'text' => 'Qualifications',
                    'icon' => 'fas fa-fw fa-graduation-cap',
                    'submenu' => [
                        [
                            'text' => 'Skills',
                            'icon' => 'fas fa-fw fa-graduation-cap',
                            'url' => '/hris/pages/personalInformation/skills/index',
                            'active' => ['/hris/pages/personalInformation/skills/create', '/hris/pages/personalInformation/skills/index', '/hris/pages/personalInformation/skills/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-skill',
                        ],
                        [
                            'text' => 'Education',
                            'icon' => 'fas fa-fw fa-graduation-cap',
                            'url' => '/hris/pages/personalInformation/educations/index',
                            'active' => ['/hris/pages/personalInformation/educations/create', '/hris/pages/personalInformation/educations/index', '/hris/pages/personalInformation/educations/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-education',
                        ],
                        [
                            'text' => 'Certifications',
                            'icon' => 'fas fa-fw fa-graduation-cap',
                            'url' => '/hris/pages/personalInformation/certifications/index',
                            'active' => ['/hris/pages/personalInformation/certifications/create', '/hris/pages/personalInformation/certifications/index', '/hris/pages/personalInformation/certifications/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-certification',
                        ],
                        [
                            'text' => 'Languages',
                            'icon' => 'fas fa-fw fa-graduation-cap',
                            'url' => '/hris/pages/personalInformation/languages/index',
                            'active' => ['/hris/pages/personalInformation/languages/create', '/hris/pages/personalInformation/languages/index', '/hris/pages/personalInformation/languages/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-language',
                        ],
                    ]
                ],
                [
                    'text' => 'Dependents',
                    'icon' => 'fas fa-fw fa-expand',
                    'url' => '/hris/pages/personalInformation/dependents/index',
                    'active' => ['/hris/pages/personalInformation/dependents/create', '/hris/pages/personalInformation/dependents/index', '/hris/pages/personalInformation/dependents/*/edit', 'regex:@^content/[0-9]+$@'],
                    'can' => 'employee-dependent',
                ],
                [
                    'text' => 'Emergency Contacts',
                    'icon' => 'fas fa-fw fa-phone-square',
                    'url' => '/hris/pages/personalInformation/emergencyContacts/index',
                    'active' => ['/hris/pages/personalInformation/emergencyContacts/create', '/hris/pages/personalInformation/emergencyContacts/index', '/hris/pages/personalInformation/emergencyContacts/*/edit', 'regex:@^content/[0-9]+$@'],
                    'can' => 'emergency-contact',
                ],
            ]
        ],
        [
            'header' => 'EMPLOYEE MANAGEMENT',
            'can' => ['employees', 'itenerary-request', 'company-document', 'document-type', 'employee-document'],
        ],
        [
            'text'    => 'Employees',
            'icon'    => 'fas fa-fw fa-users',
            'can' => ['employees', 'itenerary-request', 'company-document', 'document-type', 'employee-document'],
            'submenu' => [
                [
                    'text' => 'Employees',
                    'url'  => '/hris/pages/employees/employee/index',
                    'icon'    => 'fas fa-fw fa-users',
                    'active' => ['/hris/pages/employees/employee/create', '/hris/pages/employees/employee/index', '/hris/pages/employees/employee/*/edit', 'regex:@^content/[0-9]+$@'],
                    'can' => ['employee-add', 'employee-edit', 'employee-delete']
                ],
                /* [
                    'text' => 'Employee History',
                    'url'  => '/hris/pages/employee/employee_history/',
                    'icon'    => 'fas fa-fw fa-history',
                ],*/
                /*[
                    'text' => 'HR Form',
                    'url'  => '/hris/pages/employee/hr_form/',
                    'icon'    => 'fas fa-fw fa-folder'
                ], */
                [
                    'text' => 'Itinerary Request',
                    'url'  => '/hris/pages/employees/itineraryRequests/index',
                    'icon'    => 'fas fa-fw fa-plane-departure',
                    'active' => ['/hris/pages/employees/itineraryRequests/create', '/hris/pages/employees/itineraryRequests/index', '/hris/pages/employees/itineraryRequests/*/edit', 'regex:@^content/[0-9]+$@'],
                    'can' => 'itenerary-request'
                ],
                [
                    'text' => 'Monitor Attendance',
                    'url'  => '/hris/pages/employees/monitorAttendance/index',
                    'icon'    => 'fas fa-fw fa-clock'
                ],
                /*[
                    'text' => 'Performance Review',
                    'url'  => '/hris/pages/employee/performance_review/',
                    'icon'    => 'fas fa-fw fa-chart-bar'
                ], */
                [
                    'text' => 'Document Management',
                    'icon'    => 'fas fa-fw fa-file',
                    'can' => ['company-document', 'document-type', 'employee-document'],
                    'submenu' => [
                        [
                            'text' => 'Company Documents',
                            'url'  => '/hris/pages/employees/documents/companyDocuments/index',
                            'icon'    => 'fas fa-fw fa-file',
                            'active' => ['/hris/pages/employees/documents/companyDocuments/create', '/hris/pages/employees/documents/companyDocuments/index', '/hris/pages/employees/documents/companyDocuments/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'company-document'
                        ],
                        [
                            'text' => 'Document Types',
                            'url'  => '/hris/pages/employees/documents/types/index',
                            'icon'    => 'fas fa-fw fa-file',
                            'active' => ['/hris/pages/employees/documents/types/create', '/hris/pages/employees/documents/types/index', '/hris/pages/employees/documents/types/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'document-type'
                        ],
                        [
                            'text' => 'Employee Documents',
                            'url'  => '/hris/pages/employees/documents/employeeDocuments/index',
                            'icon'    => 'fas fa-fw fa-file',
                            'active' => ['/hris/pages/employees/documents/employeeDocuments/create', '/hris/pages/employees/documents/employeeDocuments/index', '/hris/pages/employees/documents/employeeDocuments/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employee-document'
                        ],
                    ]
                ],
            ],
        ],
        [
            'header' => 'TIME MANAGEMENT',
            'can' => ['daily-time-records','workshift-management','workshift-assignment','attendance','overtime'],
        ],
        [
            'text' => 'Time Management',
            'icon' => 'fas fa-fw fa-hourglass-half',
            'can' => ['daily-time-records','workshift-management','workshift-assignment','attendance','overtime'],
            'url' => '#',
            'submenu' => [
                [
                    'text' => 'Daily Time Records',
                    'url' => '/hris/pages/time/dailyTimeRecords/index',
                    'icon' => 'fas fa-fw fa-history',
                    'can' => 'daily-time-records'
                ],
                [
                    'text' => 'Work Shift Management',
                    'url' => '/hris/pages/time/workshiftManagement/index',
                    'icon' => 'fas fa-fw fa-clock',
                    'active' => ['/hris/pages/time/workshiftManagement/create', '/hris/pages/time/workshiftManagement/index', '/hris/pages/time/workshiftManagement/*/edit', 'regex:@^content/[0-9]+$@'],
                    'can' => 'workshift-management'
                ],
                [
                    'text' => 'Work Shift Assignment',
                    'url' => '/hris/pages/time/workshiftAssignment/index',
                    'icon' => 'fas fa-fw fa-tasks',
                    'active' => ['/hris/pages/time/workshiftAssignment/create', '/hris/pages/time/workshiftAssignment/index', '/hris/pages/time/workshiftAssignment/*/edit', 'regex:@^content/[0-9]+$@'],
                    'can' => 'workshift-assignment'
                ],
                [
                    'text' => 'Attendance',
                    'url' => '/hris/pages/time/attendances/index',
                    'icon' => 'fas fa-fw fa-calendar-check',
                    'can' => 'attendance'
                ],
                [
                    'text' => 'Overtime',
                    'url' => '/hris/pages/time/overtime/index',
                    'icon' => 'fas fa-fw fa-clock',
                    'can' => 'overtime'
                ]
            ]
        ],
        [
            'header' => 'LEAVE MANAGEMENT',
        ],
        [
            'text' => 'Leave Management',
            'icon' => 'fas fa-fw fa-share-alt',
            'submenu' => [
                [
                    'text' => 'Leave',
                    'icon' => 'fas fa-fw fa-calendar-day',
                    'active' => ['/hris/pages/leaveManagement/leaves/create', '/hris/pages/leaveManagement/leaves/index', '/hris/pages/leaveManagement/leaves/*/edit', 'regex:@^content/[0-9]+$@'],
                    'url' => '/hris/pages/leaveManagement/leaves/index'
                ],
                [
                    'text' => 'Leave Entitlement',
                    'icon' => 'fas fa-fw fa-calendar-day',
                    'url' => '/hris/pages/leaveManagement/leaveEntitlement/index'
                ],
                [
                    'text' => 'Leave Calendar',
                    'icon' => 'fas fa-fw fa-calendar-alt',
                    'url' => '/hris/pages/leaveManagement/leaveCalendar/index'
                ]
            ]
        ],
        [
            'header' => 'RECRUITMENT MANAGEMENT',
        ],
        [
            'text'    => 'Recruitment',
            'icon' => 'fas fa-fw fa-th',
            'can' => ['benefit','education-level','employment-type','experience-level','job-function','candidate','job-position'],
            'submenu' => [
                [
                    'text'    => 'Recruitment Setup',
                    'url'     => '#',
                    'icon'    => 'fas fa-fw fa-random',
                    'can' => ['benefit','education-level','employment-type','experience-level','job-function'],
                    'submenu' => [
                        [
                            'text'    => 'Benefits',
                            'url'     => '/hris/pages/recruitment/recruitmentSetup/benefits/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/benefits/create', '/hris/pages/recruitment/recruitmentSetup/benefits/index', '/hris/pages/recruitment/recruitmentSetup/benefits/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'benefit'
                        ],
                        [
                            'text' => 'Education Levels',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/educationLevels/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/educationLevels/create', '/hris/pages/recruitment/recruitmentSetup/educationLevels/index', '/hris/pages/recruitment/recruitmentSetup/educationLevels/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'education-level'
                        ],
                        [
                            'text' => 'Employment Types',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/employmentTypes/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/employmentTypes/create', '/hris/pages/recruitment/recruitmentSetup/employmentTypes/index', '/hris/pages/recruitment/recruitmentSetup/employmentTypes/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'employment-type'
                        ],
                        [
                            'text' => 'Experience Levels',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/experienceLevels/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/experienceLevels/create', '/hris/pages/recruitment/recruitmentSetup/experienceLevels/index', '/hris/pages/recruitment/recruitmentSetup/experienceLevels/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'experience-level'
                        ],
                        [
                            'text' => 'Job Functions',
                            'url'  => '/hris/pages/recruitment/recruitmentSetup/jobFunctions/index',
                            'icon'    => 'fas fa-fw fa-random',
                            'active' => ['/hris/pages/recruitment/recruitmentSetup/jobFunctions/create', '/hris/pages/recruitment/recruitmentSetup/jobFunctions/index', '/hris/pages/recruitment/recruitmentSetup/jobFunctions/*/edit', 'regex:@^content/[0-9]+$@'],
                            'can' => 'job-function'
                        ],
                    ],
                ],
                [
                    'text' => 'Job Positions',
                    'url'  => '/hris/pages/recruitment/jobPositions/index',
                    'icon' => 'fas fa-fw fa-columns',
                    'active' => ['/hris/pages/recruitment/jobPositions/create', '/hris/pages/recruitment/jobPositions/index', '/hris/pages/recruitment/jobPositions/*/edit', 'regex:@^content/[0-9]+$@'],
                    'can' => 'job-position'
                ],
                [
                    'text' => 'Candidates',
                    'url'  => '/hris/pages/recruitment/candidates/index',
                    'icon' => 'fas fa-fw fa-user-friends',
                    'active' => ['/hris/pages/recruitment/candidates/create', '/hris/pages/recruitment/candidates/index', '/hris/pages/recruitment/candidates/*/edit', 'regex:@^content/[0-9]+$@'],
                    'can' => 'candidate'
                ],
            ],
        ],
        [
            'header' => 'ADMIN REPORTS',
        ],
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
        /*[
            'header' => 'INSIGHTS',
        ],
        [
            'text' => 'Time and Management',
            'icon' => 'fas fa-fw fa-user-clock',
            'url' => '#'
        ],*/
        [
            'header' => 'DOCUMENT MANAGEMENT',
        ],
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
        [
            'header' => 'COMPANY',
        ],
        [
            'text' => 'Staff Directory',
            'icon' => 'fas fa-fw fa-user',
            'url' => '/hris/pages/company/staffDirectory/index'
        ],
        [
            'header' => 'TRAINING MANAGEMENT',
        ],
        [
            'text' => 'Training',
            'icon' => 'fas fa-fw fa-briefcase',
            'submenu' => [
                [
                    'text' => 'My Training Sessions',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'url' => '/hris/pages/training/myTraining/index'
                ],
                /*[
                    'text' => 'All Training Sessions',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'url' => '#'
                ],
                [
                    'text' => 'Training Sessions of Direct Reports',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'url' => '#'
                ],*/
                [
                    'text' => 'Training Sessions Coordinated by Me',
                    'icon' => 'fas fa-fw fa-briefcase',
                    'url' => '/hris/pages/training/coordinated/index'
                ],
            ]
        ],
        [
            'header' => 'PERFORMANCE',
        ],
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
       /* [
            'header' => 'TRAVEL MANAGEMENT',
        ],
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
        ], */
        [
            'header' => 'FINANCE MANAGEMENT',
        ],
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
        [
            'header' => 'USER REPORTS',
        ],
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
        //JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
        App\MenuFilter::class,
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
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'FullCalendar',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/locales-all.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.css',
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
