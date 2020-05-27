<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        //ADD CHANNELS FOR LOGS

        //ADMIN

        //COMPANY STRUCTURE LOGS

        'company' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/company/company.log'),
          'level' => 'info',
        ],


        //JOB DETAILS
        //EMPLOYEMENT STATUSES LOGS

        'employmentStatuses' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/jobDetails/employmentStatuses.log'),
          'level' => 'info',
        ],

        //JOB TITLES LOGS

        'jobTitles' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/jobDetails/jobTitles.log'),
          'level' => 'info',
        ],

        //PAY GRADES LOGS

        'payGrades' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/jobDetails/payGrades.log'),
          'level' => 'info',
        ],

        //PROPERTIES SETUP
        //CLIENTS LOGS

        'clients' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/properties/clients.log'),
          'level' => 'info',
        ],

        //EMPLOYEE PROJECTS LOGS

        'employeeProjects' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/properties/employeeProjects.log'),
          'level' => 'info',
        ],

        //PROJECTS LOGS

        'projects' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/properties/projects.log'),
          'level' => 'info',
        ],

        //QUALIFICATIONS SETUP
        //CERTIFICATIONS LOGS

        'certifications' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/qualifications/certifications.log'),
          'level' => 'info',
        ],

        //EDUCATIONS LOGS

        'educations' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/qualifications/educations.log'),
          'level' => 'info',
        ],

        //LANGUAGES LOGS

        'languages' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/qualifications/languages.log'),
          'level' => 'info',
        ],

        //SKILLS LOGS

        'skills' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/qualifications/skills.log'),
          'level' => 'info',
        ],

        //TRAINING SETUP
        //COURSES LOGS

        'courses' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/training/courses.log'),
          'level' => 'info',
        ],

        //EDUCATIONS LOGS

        'employeeTrainingSessions' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/training/employeeTrainingSessions.log'),
          'level' => 'info',
        ],

        //LANGUAGES LOGS

        'trainingSessions' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/training/trainingSessions.log'),
          'level' => 'info',
        ],

        //BENEFIT ADMINISTRATION
        //EMPLOYEE EXPENSES LOGS

        'employeeExpenses' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/benefits/employeeExpenses.log'),
          'level' => 'info',
        ],

        //EXPENSES CATEGORIES LOGS

        'expensesCategories' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/benefits/expensesCategories.log'),
          'level' => 'info',
        ],

        //PAYMENT METHODS LOGS

        'paymentMethods' => [
          'driver' => 'single',
          'path' => storage_path('logs/admin/benefits/paymentMethods.log'),
          'level' => 'info',
        ],

        //RECRUITMENT
        //JOB POSITIONS LOGS

        'jobPositions' => [
            'driver' => 'single',
            'path' => storage_path('logs/recruitment/jobPositions.log'),
            'level' => 'info'
        ],
        
        //CANDIDATES LOGS

        'candidates' => [
            'driver' => 'single',
            'path' => storage_path('logs/recruitment/candidates.log'),
            'level' => 'info'
        ],

        //RECRUITMENT SETUP
        //BENEFITS LOGS

        'benefits' => [
          'driver' => 'single',
          'path' => storage_path('logs/recruitment/recruitmentSetup/benefits.log'),
          'level' => 'info',
        ],

        //EDUCATION LEVELS LOGS

        'educationLevels' => [
          'driver' => 'single',
          'path' => storage_path('logs/recruitment/recruitmentSetup/educationLevels.log'),
          'level' => 'info',
        ],

        //EMPLOYMENT TYPES LOGS

        'employmentTypes' => [
          'driver' => 'single',
          'path' => storage_path('logs/recruitment/recruitmentSetup/employmentTypes.log'),
          'level' => 'info',
        ],

        //EXPERIENCE LEVELS LOGS

        'experienceLevels' => [
          'driver' => 'single',
          'path' => storage_path('logs/recruitment/recruitmentSetup/experienceLevels.log'),
          'level' => 'info',
        ],

        //JOB FUNCTIONS LOGS

        'jobFunctions' => [
          'driver' => 'single',
          'path' => storage_path('logs/recruitment/recruitmentSetup/jobFunctions.log'),
          'level' => 'info',
        ],
    ],

];
