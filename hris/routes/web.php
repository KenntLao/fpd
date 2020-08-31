<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserID;
use App\Http\Middleware\CheckPermission;
use App\hris_employee;
use App\Notifications\SupervisorNotif;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ADMINISTRATION */

/* COMPANY PAGE */
Route::middleware([CheckUserID::class])->group(function(){

    Route::get('/hris/logout', 'LoginController@logout');
    
    Route::group(['middleware' => 'CheckPermission:admin'], function(){
        Route::get('/hris/pages/admin/company/index', 'CompanyController@index');
        /* ADD COMPANY STRUCTURE */
        Route::get('/hris/pages/admin/company/create', 'CompanyController@create');
        Route::post('/hris/pages/admin/company', 'CompanyController@store');
        /* EDIT COMPANY STRUCTURE */
        Route::get('/hris/pages/admin/company/{company}/edit', 'CompanyController@edit');
        /* UPDATE COMPANY STRUCTURE */
        Route::patch('/hris/pages/admin/company/update/{company}', 'CompanyController@update');
        /* DELETE COMPANY STRUCTURE */
        Route::delete('/hris/pages/admin/company/delete/{company}', 'CompanyController@destroy');

        /* JOB DETAILS SETUP */

        /* JOB TITLES PAGE */
        Route::get('/hris/pages/admin/jobDetails/jobTitles/index', 'JobTitleController@index');
        /* ADD JOB TITLES */
        Route::get('/hris/pages/admin/jobDetails/jobTitles/create', 'JobTitleController@create');
        Route::post('/hris/pages/admin/jobDetails/jobTitles', 'JobTitleController@store');
        /* EDIT JOB TITLES */
        Route::get('/hris/pages/admin/jobDetails/jobTitles/{jobTitle}/edit', 'JobTitleController@edit');
        /* UPDATE JOB TITLES */
        Route::patch('/hris/pages/admin/jobDetails/jobTitles/update/{jobTitle}', 'JobTitleController@update');
        /* DELETE JOB TITLES */
        Route::delete('/hris/pages/admin/jobDetails/jobTitles/delete/{jobTitle}', 'JobTitleController@destroy');

        /* PAY GRADES */
        Route::get('/hris/pages/admin/jobDetails/payGrades/index', 'PayGradeController@index');
        /* ADD PAY GRADES */
        Route::get('/hris/pages/admin/jobDetails/payGrades/create', 'PayGradeController@create');
        Route::post('/hris/pages/admin/jobDetails/payGrades', 'PayGradeController@store');
        /* EDIT PAY GRADES */
        Route::get('/hris/pages/admin/jobDetails/payGrades/{payGrade}/edit', 'PayGradeController@edit');
        /* UPDATE PAY GRADES */
        Route::patch('/hris/pages/admin/jobDetails/payGrades/update/{payGrade}', 'PayGradeController@update');
        /* DELETE PAY GRADES */
        Route::delete('/hris/pages/admin/jobDetails/payGrades/delete/{payGrade}', 'PayGradeController@destroy');

        /* EMPLOYMENT STATUS PAGE */
        Route::get('/hris/pages/admin/jobDetails/employmentStatuses/index', 'EmploymentStatusController@index');
        /* ADD EMPLOYMENT STATUS */
        Route::get('/hris/pages/admin/jobDetails/employmentStatuses/create', 'EmploymentStatusController@create');
        Route::post('/hris/pages/admin/jobDetails/employmentStatuses', 'EmploymentStatusController@store');
        /* EDIT EMPLOYMENT STATUS */
        Route::get('/hris/pages/admin/jobDetails/employmentStatuses/{employmentStatus}/edit', 'EmploymentStatusController@edit');
        /* UPDATE EMPLOYMENT STATUS */
        Route::patch('/hris/pages/admin/jobDetails/employmentStatuses/update/{employmentStatus}', 'EmploymentStatusController@update');
        /* DELETE EMPLOYMENT STATUS */
        Route::delete('/hris/pages/admin/jobDetails/employmentStatuses/delete/{employmentStatus}', 'EmploymentStatusController@destroy');

        /* QUALIFICATIONS SETUP */

        /* SKILLS PAGE */
        Route::get('/hris/pages/admin/qualifications/skills/index', 'SkillController@index');
        /* ADD SKILLS */
        Route::get('/hris/pages/admin/qualifications/skills/create', 'SkillController@create');
        Route::post('/hris/pages/admin/qualifications/skills', 'SkillController@store');
        /* EDIT SKILLS */
        Route::get('/hris/pages/admin/qualifications/skills/{skill}/edit', 'SkillController@edit');
        /* UPDATE SKILLS */
        Route::patch('/hris/pages/admin/qualifications/skills/update/{skill}', 'SkillController@update');
        /* DELETE SKILLS */
        Route::delete('/hris/pages/admin/qualifications/skills/delete/{skill}', 'SkillController@destroy');

        /* EDUCATIONS PAGE */
        Route::get('/hris/pages/admin/qualifications/educations/index', 'EducationController@index');
        /* ADD EDUCATIONS */
        Route::get('/hris/pages/admin/qualifications/educations/create', 'EducationController@create');
        Route::post('/hris/pages/admin/qualifications/educations', 'EducationController@store');
        /* EDIT EDUCATIONS */
        Route::get('/hris/pages/admin/qualifications/educations/{education}/edit', 'EducationController@edit');
        /* UPDATE EDUCATIONS */
        Route::patch('/hris/pages/admin/qualifications/educations/update/{education}', 'EducationController@update');
        /* DELETE EDUCATIONS */
        Route::delete('/hris/pages/admin/qualifications/educations/delete/{education}', 'EducationController@destroy');

        /* CERTIFICATIONS PAGE */
        Route::get('/hris/pages/admin/qualifications/certifications/index', 'CertificationController@index');
        /* ADD CERTIFICATIONS */
        Route::get('/hris/pages/admin/qualifications/certifications/create', 'CertificationController@create');
        Route::post('/hris/pages/admin/qualifications/certifications', 'CertificationController@store');
        /* EDIT CERTIFICATIONS */
        Route::get('/hris/pages/admin/qualifications/certifications/{certification}/edit', 'CertificationController@edit');
        /* UPDATE CERTIFICATIONS */
        Route::patch('/hris/pages/admin/qualifications/certifications/update/{certification}', 'CertificationController@update');
        /* DELETE CERTIFICATIONS */
        Route::delete('/hris/pages/admin/qualifications/certifications/delete/{certification}', 'CertificationController@destroy');

        /* LANGUAGES PAGE */
        Route::get('/hris/pages/admin/qualifications/languages/index', 'LanguageController@index');
        /* ADD LANGUAGES */
        Route::get('/hris/pages/admin/qualifications/languages/create', 'LanguageController@create');
        Route::post('/hris/pages/admin/qualifications/languages', 'LanguageController@store');
        /* EDIT LANGUAGES */
        Route::get('/hris/pages/admin/qualifications/languages/{language}/edit', 'LanguageController@edit');
        /* UPDATE LANGUAGES */
        Route::patch('/hris/pages/admin/qualifications/languages/update/{language}', 'LanguageController@update');
        /* DELETE LANGUAGES */
        Route::delete('/hris/pages/admin/qualifications/languages/delete/{language}', 'LanguageController@destroy');

        /* TRAINING SETUP */

        /* COURSES PAGE */
        Route::get('/hris/pages/admin/training/courses/index', 'CourseController@index');
        /* ADD COURSES */
        Route::get('/hris/pages/admin/training/courses/create', 'CourseController@create');
        Route::post('/hris/pages/admin/training/courses', 'CourseController@store');
        /* EDIT COURSES */
        Route::get('/hris/pages/admin/training/courses/{course}/edit', 'CourseController@edit');
        /* UPDATE COURSES */
        Route::patch('/hris/pages/admin/training/courses/update/{course}', 'CourseController@update');
        /* DELETE COURSES */
        Route::delete('/hris/pages/admin/training/courses/delete/{course}', 'CourseController@destroy');

        /* EMPLOYEE TRAINING SESSIONS PAGE */
        Route::get('/hris/pages/admin/training/employeeTrainingSessions/index', 'EmployeeTrainingSessionController@index');
        /* ADD EMPLOYEE TRAINING SESSIONS */
        Route::get('/hris/pages/admin/training/employeeTrainingSessions/create', 'EmployeeTrainingSessionController@create');
        Route::post('/hris/pages/admin/training/employeeTrainingSessions', 'EmployeeTrainingSessionController@store');
        /* EDIT EMPLOYEE TRAINING SESSIONS */
        Route::get('/hris/pages/admin/training/employeeTrainingSessions/{employeeTrainingSession}/edit', 'EmployeeTrainingSessionController@edit');
        /* UPDATE EMPLOYEE TRAINING SESSIONS */
        Route::patch('/hris/pages/admin/training/employeeTrainingSessions/update/{employeeTrainingSession}', 'EmployeeTrainingSessionController@update');
        /* DELETE EMPLOYEE TRAINING SESSIONS */
        Route::delete('/hris/pages/admin/training/employeeTrainingSessions/delete/{employeeTrainingSession}', 'EmployeeTrainingSessionController@destroy');

        /* TRAINING SESSIONS PAGE */
        Route::get('/hris/pages/admin/training/trainingSessions/index', 'TrainingSessionController@index');
        /* ADD TRAINING SESSIONS */
        Route::get('/hris/pages/admin/training/trainingSessions/create', 'TrainingSessionController@create');
        Route::post('/hris/pages/admin/training/trainingSessions', 'TrainingSessionController@store');
        /* EDIT TRAINING SESSIONS */
        Route::get('/hris/pages/admin/training/trainingSessions/{trainingSession}/edit', 'TrainingSessionController@edit');
        /* UPDATE TRAINING SESSIONS */
        Route::patch('/hris/pages/admin/training/trainingSessions/update/{trainingSession}', 'TrainingSessionController@update');
        /* DELETE TRAINING SESSIONS */
        Route::delete('/hris/pages/admin/training/trainingSessions/delete/{trainingSession}', 'TrainingSessionController@destroy');

        /* PROPERTIES SETUP */

        /* CLIENTS PAGE */
        Route::get('/hris/pages/admin/properties/clients/index', 'ClientController@index');
        /* ADD CLIENTS */
        Route::get('/hris/pages/admin/properties/clients/create', 'ClientController@create');
        Route::post('/hris/pages/admin/properties/clients', 'ClientController@store');
        /* EDIT CLIENTS */
        Route::get('/hris/pages/admin/properties/clients/{client}/edit', 'ClientController@edit');
        /* UPDATE CLIENTS */
        Route::patch('/hris/pages/admin/properties/clients/update/{client}', 'ClientController@update');
        /* DELETE CLIENTS */
        Route::delete('/hris/pages/admin/properties/clients/delete/{client}', 'ClientController@destroy');

        /* PROJECTS PAGE */
        Route::get('/hris/pages/admin/properties/projects/index', 'ProjectController@index');
        /* ADD PROJECTS */
        Route::get('/hris/pages/admin/properties/projects/create', 'ProjectController@create');
        Route::post('/hris/pages/admin/properties/projects', 'ProjectController@store');
        /* EDIT PROJECTS */
        Route::get('/hris/pages/admin/properties/projects/{project}/edit', 'ProjectController@edit');
        /* UPDATE PROJECTS */
        Route::patch('/hris/pages/admin/properties/projects/update/{project}', 'ProjectController@update');
        /* DELETE PROJECTS */
        Route::delete('/hris/pages/admin/properties/projects/delete/{project}', 'ProjectController@destroy');

        /* EMPLOYEE PROJECTS PAGE */
        Route::get('/hris/pages/admin/properties/employeeProjects/index', 'EmployeeProjectController@index');
        /* ADD EMPLOYEE PROJECTS */
        Route::get('/hris/pages/admin/properties/employeeProjects/create', 'EmployeeProjectController@create');
        Route::post('/hris/pages/admin/properties/employeeProjects', 'EmployeeProjectController@store');
        /* EDIT EMPLOYEE PROJECTS */
        Route::get('/hris/pages/admin/properties/employeeProjects/{employeeProject}/edit', 'EmployeeProjectController@edit');
        /* UPDATE EMPLOYEE PROJECTS */
        Route::patch('/hris/pages/admin/properties/employeeProjects/update/{employeeProject}', 'EmployeeProjectController@update');
        /* DELETE EMPLOYEE PROJECTS */
        Route::delete('/hris/pages/admin/properties/employeeProjects/delete/{employeeProject}', 'EmployeeProjectController@destroy');

        /* LEAVE SETTINGS PAGE */

        /* LEAVE PERIODS PAGE */
        Route::get('/hris/pages/admin/leave/leavePeriods/index', 'LeavePeriodController@index');
        /* ADD LEAVE PERIODS */
        Route::get('/hris/pages/admin/leave/leavePeriods/create', 'LeavePeriodController@create');
        Route::post('/hris/pages/admin/leave/leavePeriods', 'LeavePeriodController@store');
        /* EDIT LEAVE PERIODS */
        Route::get('/hris/pages/admin/leave/leavePeriods/{leavePeriod}/edit', 'LeavePeriodController@edit');
        /* UPDATE LEAVE PERIODS */
        Route::patch('/hris/pages/admin/leave/leavePeriods/update/{leavePeriod}', 'LeavePeriodController@update');
        /* DELETE LEAVE PERIODS */
        Route::delete('/hris/pages/admin/leave/leavePeriods/delete/{leavePeriod}', 'LeavePeriodController@destroy');

        /* LEAVE TYPES PAGE */
        Route::get('/hris/pages/admin/leave/leaveTypes/index', 'LeaveTypeController@index');
        /* ADD LEAVE TYPES */
        Route::get('/hris/pages/admin/leave/leaveTypes/create', 'LeaveTypeController@create');
        Route::post('/hris/pages/admin/leave/leaveTypes', 'LeaveTypeController@store');
        /* EDIT LEAVE TYPES */
        Route::get('/hris/pages/admin/leave/leaveTypes/{leaveType}/edit', 'LeaveTypeController@edit');
        /* UPDATE LEAVE TYPES */
        Route::patch('/hris/pages/admin/leave/leaveTypes/update/{leaveType}', 'LeaveTypeController@update');
        /* DELETE LEAVE TYPES */
        Route::delete('/hris/pages/admin/leave/leaveTypes/delete/{leaveType}', 'LeaveTypeController@destroy');

        /* LEAVE GROUPS PAGE */
        Route::get('/hris/pages/admin/leave/leaveGroups/index', 'LeaveGroupController@index');
        /* ADD LEAVE GROUPS */
        Route::get('/hris/pages/admin/leave/leaveGroups/create', 'LeaveGroupController@create');
        Route::post('/hris/pages/admin/leave/leaveGroups', 'LeaveGroupController@store');
        /* EDIT LEAVE GROUPS */
        Route::get('/hris/pages/admin/leave/leaveGroups/{leaveGroup}/edit', 'LeaveGroupController@edit');
        /* UPDATE LEAVE GROUPS */
        Route::patch('/hris/pages/admin/leave/leaveGroups/update/{leaveGroup}', 'LeaveGroupController@update');
        /* DELETE LEAVE GROUPS */
        Route::delete('/hris/pages/admin/leave/leaveGroups/delete/{leaveGroup}', 'LeaveGroupController@destroy');

        /* LEAVE GROUP EMPLOYEES PAGE */
        Route::get('/hris/pages/admin/leave/leaveGroupEmployees/index', 'LeaveGroupEmployeeController@index');
        /* ADD LEAVE GROUP EMPLOYEES */
        Route::get('/hris/pages/admin/leave/leaveGroupEmployees/create', 'LeaveGroupEmployeeController@create');
        Route::post('/hris/pages/admin/leave/leaveGroupEmployees', 'LeaveGroupEmployeeController@store');
        /* EDIT LEAVE GROUP EMPLOYEES */
        Route::get('/hris/pages/admin/leave/leaveGroupEmployees/{leaveGroupEmployee}/edit', 'LeaveGroupEmployeeController@edit');
        /* UPDATE LEAVE GROUP EMPLOYEES */
        Route::patch('/hris/pages/admin/leave/leaveGroupEmployees/update/{leaveGroupEmployee}', 'LeaveGroupEmployeeController@update');
        /* DELETE LEAVE GROUP EMPLOYEES */
        Route::delete('/hris/pages/admin/leave/leaveGroupEmployees/delete/{leaveGroupEmployee}', 'LeaveGroupEmployeeController@destroy');

        /* WORK WEEK PAGE */
        Route::get('/hris/pages/admin/leave/workWeeks/index', 'WorkWeekController@index');
        /* ADD WORK WEEK */
        Route::get('/hris/pages/admin/leave/workWeeks/create', 'WorkWeekController@create');
        Route::post('/hris/pages/admin/leave/workWeeks', 'WorkWeekController@store');
        /* EDIT WORK WEEK */
        Route::get('/hris/pages/admin/leave/workWeeks/{workWeek}/edit', 'WorkWeekController@edit');
        /* UPDATE WORK WEEK */
        Route::patch('/hris/pages/admin/leave/workWeeks/update/{workWeek}', 'WorkWeekController@update');
        /* DELETE WORK WEEK */
        Route::delete('/hris/pages/admin/leave/workWeeks/delete/{workWeek}', 'WorkWeekController@destroy');

        /* HOLIDAY PAGE */
        Route::get('/hris/pages/admin/leave/holidays/index', 'HolidayController@index');
        /* ADD HOLIDAY */
        Route::get('/hris/pages/admin/leave/holidays/create', 'HolidayController@create');
        Route::post('/hris/pages/admin/leave/holidays', 'HolidayController@store');
        /* EDIT HOLIDAY */
        Route::get('/hris/pages/admin/leave/holidays/{holiday}/edit', 'HolidayController@edit');
        /* UPDATE HOLIDAY */
        Route::patch('/hris/pages/admin/leave/holidays/update/{holiday}', 'HolidayController@update');
        /* DELETE HOLIDAY */
        Route::delete('/hris/pages/admin/leave/holidays/delete/{holiday}', 'HolidayController@destroy');

        /* LEAVE RULES PAGE */
        Route::get('/hris/pages/admin/leave/leaveRules/index', 'LeaveRuleController@index');
        /* ADD LEAVE RULES */
        Route::get('/hris/pages/admin/leave/leaveRules/create', 'LeaveRuleController@create');
        Route::post('/hris/pages/admin/leave/leaveRules', 'LeaveRuleController@store');
        /* EDIT LEAVE RULES */
        Route::get('/hris/pages/admin/leave/leaveRules/{leaveRule}/edit', 'LeaveRuleController@edit');
        /* UPDATE LEAVE RULES */
        Route::patch('/hris/pages/admin/leave/leaveRules/update/{leaveRule}', 'LeaveRuleController@update');
        /* DELETE LEAVE RULES */
        Route::delete('/hris/pages/admin/leave/leaveRules/delete/{leaveRule}', 'LeaveRuleController@destroy');

        /* PAID TIME OFF PAGE */
        Route::get('/hris/pages/admin/leave/paidTimeOffs/index', 'PaidTimeOffController@index');
        /* ADD PAID TIME OFF */
        Route::get('/hris/pages/admin/leave/paidTimeOffs/create', 'PaidTimeOffController@create');
        Route::post('/hris/pages/admin/leave/paidTimeOffs', 'PaidTimeOffController@store');
        /* EDIT PAID TIME OFF */
        Route::get('/hris/pages/admin/leave/paidTimeOffs/{paidTimeOff}/edit', 'PaidTimeOffController@edit');
        /* UPDATE PAID TIME OFF */
        Route::patch('/hris/pages/admin/leave/paidTimeOffs/update/{paidTimeOff}', 'PaidTimeOffController@update');
        /* DELETE PAID TIME OFF */
        Route::delete('/hris/pages/admin/leave/paidTimeOffs/delete/{paidTimeOff}', 'PaidTimeOffController@destroy');

        /* BENEFITS ADMINISTRATION */

        /* EXPENSES CATEGORIES PAGE */
        Route::get('/hris/pages/admin/benefits/expensesCategories/index', 'ExpensesCategoryController@index');
        /* ADD EXPENSE CATEGORIES */
        Route::get('/hris/pages/admin/benefits/expensesCategories/create', 'ExpensesCategoryController@create');
        Route::post('/hris/pages/admin/benefits/expensesCategories', 'ExpensesCategoryController@store');
        /* EDIT EXPENSE CATEGORIES */
        Route::get('/hris/pages/admin/benefits/expensesCategories/{expensesCategory}/edit', 'ExpensesCategoryController@edit');
        /* UPDATE EXPENSE CATEGORIES */
        Route::patch('/hris/pages/admin/benefits/expensesCategories/update/{expensesCategory}', 'ExpensesCategoryController@update');
        /* DELETE EXPENSE CATEGORIES */
        Route::delete('/hris/pages/admin/benefits/expensesCategories/delete/{expensesCategory}', 'ExpensesCategoryController@destroy');

        /* PAYMENT METHODS PAGE */
        Route::get('/hris/pages/admin/benefits/paymentMethods/index', 'PaymentMethodController@index');
        /* ADD PAYMENT METHODS */
        Route::get('/hris/pages/admin/benefits/paymentMethods/create', 'PaymentMethodController@create');
        Route::post('/hris/pages/admin/benefits/paymentMethods', 'PaymentMethodController@store');
        /* EDIT PAYMENT METHODS */
        Route::get('/hris/pages/admin/benefits/paymentMethods/{paymentMethod}/edit', 'PaymentMethodController@edit');
        /* UPDATE PAYMENT METHODS */
        Route::patch('/hris/pages/admin/benefits/paymentMethods/update/{paymentMethod}', 'PaymentMethodController@update');
        /* DELETE PAYMENT METHODS */
        Route::delete('/hris/pages/admin/benefits/paymentMethods/delete/{paymentMethod}', 'PaymentMethodController@destroy');

        /* EMPLOYEE EXPENSES PAGE */
        Route::get('/hris/pages/admin/benefits/employeeExpenses/index', 'EmployeeExpenseController@index');
        /* ADD EMPLOYEE EXPENSES */
        Route::get('/hris/pages/admin/benefits/employeeExpenses/create', 'EmployeeExpenseController@create');
        Route::post('/hris/pages/admin/benefits/employeeExpenses', 'EmployeeExpenseController@store');
        /* EDIT EMPLOYEE EXPENSES */
        Route::get('/hris/pages/admin/benefits/employeeExpenses/{employeeExpense}/edit', 'EmployeeExpenseController@edit');
        /* UPDATE EMPLOYEE EXPENSES */
        Route::patch('/hris/pages/admin/benefits/employeeExpenses/update/{employeeExpense}', 'EmployeeExpenseController@update');
        Route::get('/hris/pages/admin/benefits/employeeExpenses/updateStatus/{status}/{employeeExpense}', 'EmployeeExpenseController@updateStatus');
        /* UPDATE EMPLOYEE EXPENSES STATUS*/
        Route::patch('/hris/pages/admin/benefits/employeeExpenses/updateStatus/{employeeExpense}', 'EmployeeExpenseController@updateStatus');
        /* DELETE EMPLOYEE EXPENSES */
        Route::delete('/hris/pages/admin/benefits/employeeExpenses/delete/{employeeExpense}', 'EmployeeExpenseController@destroy');
        //show
        Route::get('/hris/pages/admin/benefits/employeeExpenses/{employeeExpense}/show', 'EmployeeExpenseController@show');

        /* OVERTIME ADMINISTRATION */

        /* OVERTIME CATEGORIES PAGE */
        Route::get('/hris/pages/admin/overtime/overtimeCategories/index', 'OvertimeCategoryController@index');
        /* ADD OVERTIME CATEGORIES */
        Route::get('/hris/pages/admin/overtime/overtimeCategories/create', 'OvertimeCategoryController@create');
        Route::post('/hris/pages/admin/overtime/overtimeCategories', 'OvertimeCategoryController@store');
        /* EDIT OVERTIME CATEGORIES */
        Route::get('/hris/pages/admin/overtime/overtimeCategories/{overtimeCategory}/edit', 'OvertimeCategoryController@edit');
        /* UPDATE OVERTIME CATEGORIES */
        Route::patch('/hris/pages/admin/overtime/overtimeCategories/update/{overtimeCategory}', 'OvertimeCategoryController@update');
        /* DELETE OVERTIME CATEGORIES */
        Route::delete('/hris/pages/admin/overtime/overtimeCategories/delete/{overtimeCategory}', 'OvertimeCategoryController@destroy');

        /* COMPANY LOANS */

        /* LOAN TYPES PAGE */
        Route::get('/hris/pages/admin/loans/loanTypes/index', 'CompanyLoanTypeController@index');
        /* ADD LOAN TYPES */
        Route::get('/hris/pages/admin/loans/loanTypes/create', 'CompanyLoanTypeController@create');
        Route::post('/hris/pages/admin/loans/loanTypes', 'CompanyLoanTypeController@store');
        /* EDIT LOAN TYPES */
        Route::get('/hris/pages/admin/loans/loanTypes/{loanType}/edit', 'CompanyLoanTypeController@edit');
        /* UPDATE LOAN TYPES */
        Route::patch('/hris/pages/admin/loans/loanTypes/update/{loanType}', 'CompanyLoanTypeController@update');
        /* DELETE LOAN TYPES */
        Route::delete('/hris/pages/admin/loans/loanTypes/delete/{loanType}', 'CompanyLoanTypeController@destroy');

        /* EMPLOYEE LOANS PAGE */
        Route::get('/hris/pages/admin/loans/employeeLoans/index', 'EmployeeLoanController@index');
        /* ADD EMPLOYEE LOANS */
        Route::get('/hris/pages/admin/loans/employeeLoans/create', 'EmployeeLoanController@create');
        Route::post('/hris/pages/admin/loans/employeeLoans', 'EmployeeLoanController@store');
        /* EDIT EMPLOYEE LOANS */
        Route::get('/hris/pages/admin/loans/employeeLoans/{employeeLoan}/edit', 'EmployeeLoanController@edit');
        /* UPDATE EMPLOYEE LOANS */
        Route::patch('/hris/pages/admin/loans/employeeLoans/update/{employeeLoan}', 'EmployeeLoanController@update');
        /* DELETE EMPLOYEE LOANS */
        Route::delete('/hris/pages/admin/loans/employeeLoans/delete/{employeeLoan}', 'EmployeeLoanController@destroy');

        /* COMPANY ASSETS */
        /* TYPES */

        /* TYPES PAGE */
        Route::get('/hris/pages/admin/companyAssets/types/index', 'CompanyAssetTypeController@index');
        /* ADD TYPES */
        Route::get('/hris/pages/admin/companyAssets/types/create', 'CompanyAssetTypeController@create');
        Route::post('/hris/pages/admin/companyAssets/types', 'CompanyAssetTypeController@store');
        /* EDIT TYPES */
        Route::get('/hris/pages/admin/companyAssets/types/{type}/edit', 'CompanyAssetTypeController@edit');
        /* UPDATE TYPES */
        Route::patch('/hris/pages/admin/companyAssets/types/update/{type}', 'CompanyAssetTypeController@update');
        /* DELETE TYPES */
        Route::delete('/hris/pages/admin/companyAssets/types/delete/{type}', 'CompanyAssetTypeController@destroy');
        /* TYPES */

        /* ASSETS PAGE */
        Route::get('/hris/pages/admin/companyAssets/assets/index', 'CompanyAssetController@index');
        /* ADD ASSETS */
        Route::get('/hris/pages/admin/companyAssets/assets/create', 'CompanyAssetController@create');
        Route::post('/hris/pages/admin/companyAssets/assets', 'CompanyAssetController@store');
        /* EDIT ASSETS */
        Route::get('/hris/pages/admin/companyAssets/assets/{asset}/edit', 'CompanyAssetController@edit');
        /* UPDATE ASSETS */
        Route::patch('/hris/pages/admin/companyAssets/assets/update/{asset}', 'CompanyAssetController@update');
        /* DELETE ASSETS */
        Route::delete('/hris/pages/admin/companyAssets/assets/delete/{asset}', 'CompanyAssetController@destroy');

        /* AUDIT LOG PAGE */
        Route::get('/hris/pages/admin/auditLog/index', 'SystemLogController@index');

        /* DEPARTMENT MODULE */
        Route::get('/hris/pages/admin/department/index', 'DepartmentController@index');
        Route::get('/hris/pages/admin/department/create', 'DepartmentController@create');
        Route::post('/hris/pages/admin/department', 'DepartmentController@store');
        /* EDIT */
        Route::get('/hris/pages/admin/department/{department}/edit', 'DepartmentController@edit');
        Route::patch('/hris/pages/admin/department/update/{department}', 'DepartmentController@update');
        /* DELETE */
        Route::delete('/hris/pages/admin/department/delete/{department}', 'DepartmentController@destroy');
    });

    /* EMPLOYEE MANAGEMENT */
    //add

    // EXCEL IMPORT / EXPORT
    Route::get('/hris/pages/employees/employee/table', 'EmployeeController@table');
    Route::post('/hris/pages/employees/employee/import', 'EmployeeController@import');
    Route::get('/hris/pages/employees/employee/download', 'EmployeeController@export');

    // MONITOR ATTENDANCE
    Route::get('/hris/pages/employees/monitorAttendance/index', 'MonitorAttendanceController@index');
    Route::get('/hris/pages/employees/monitorAttendance/', 'MonitorAttendanceController@search')->name('monitor_attendance.search');
    
    // GET AJAX DATA FOR SUPERVISOR
    Route::post('/hris/pages/employees/employee/getSupervisor', 'EmployeeController@renderSupervisor')->name('getSupervisor.fetch');

    Route::get('/hris/pages/employees/employee/index', 'EmployeeController@index');
    Route::get('/hris/pages/employees/employee/create', 'EmployeeController@create');
    Route::post('/hris/pages/employees/employee', 'EmployeeController@store');
    //edit
    Route::get('/hris/pages/employees/employee/{employee}/edit', 'EmployeeController@edit');
    Route::patch('/hris/pages/employees/employee/update/{employee}', 'EmployeeController@update');
    //show
    Route::get('/hris/pages/employees/employee/{employee}', 'EmployeeController@show');
    //delete
    Route::delete('/hris/pages/employees/employee/delete/{employee}', 'EmployeeController@destroy');

    

    // DOCUMENT MANAGEMENT
    // COMPANY DOCUMENTS
    Route::get('/hris/pages/employees/documents/companyDocuments/index', 'CompanyDocumentController@index');
    Route::get('/hris/pages/employees/documents/companyDocuments/create', 'CompanyDocumentController@create');
    Route::post('/hris/pages/employees/documents/companyDocuments', 'CompanyDocumentController@store');
    //edit
    Route::get('/hris/pages/employees/documents/companyDocuments/{document}/edit', 'CompanyDocumentController@edit')->name('editCompanyDocument');
    Route::patch('/hris/pages/employees/documents/companyDocuments/update/{document}', 'CompanyDocumentController@update');
    //delete
    Route::delete('/hris/pages/employees/documents/companyDocuments/delete/{document}', 'CompanyDocumentController@destroy');
    // GET AJAX DATA FOR EMPLOYEE
    Route::post('/hris/pages/employees/documents/companyDocuments/getEmployee', 'CompanyDocumentController@renderEmployee')->name('getEmployee.fetch');
    // DOCUMENT TYPES
    Route::get('/hris/pages/employees/documents/types/index', 'DocumentTypeController@index');
    Route::get('/hris/pages/employees/documents/types/create', 'DocumentTypeController@create');
    Route::post('/hris/pages/employees/documents/types', 'DocumentTypeController@store');
    //edit
    Route::get('/hris/pages/employees/documents/types/{type}/edit', 'DocumentTypeController@edit');
    Route::patch('/hris/pages/employees/documents/types/update/{type}', 'DocumentTypeController@update');
    //delete
    Route::delete('/hris/pages/employees/documents/types/delete/{type}', 'DocumentTypeController@destroy');
    // EMPLOYEE DOCUMENTS
    Route::get('/hris/pages/employees/documents/employeeDocuments/index', 'EmployeeDocumentController@index');
    Route::get('/hris/pages/employees/documents/employeeDocuments/create', 'EmployeeDocumentController@create');
    Route::post('/hris/pages/employees/documents/employeeDocuments', 'EmployeeDocumentController@store');
    //edit
    Route::get('/hris/pages/employees/documents/employeeDocuments/{document}/edit', 'EmployeeDocumentController@edit');
    Route::patch('/hris/pages/employees/documents/employeeDocuments/update/{document}', 'EmployeeDocumentController@update');
    //delete
    Route::delete('/hris/pages/employees/documents/employeeDocuments/delete/{document}', 'EmployeeDocumentController@destroy');

        // ITINERARY REQUEST
        Route::get('/hris/pages/employees/itineraryRequests/index', 'ItineraryRequestController@index');
        Route::get('/hris/pages/employees/itineraryRequests/create', 'ItineraryRequestController@create');
        Route::post('/hris/pages/employees/itineraryRequests', 'ItineraryRequestController@store');
        //edit
        Route::get('/hris/pages/employees/itineraryRequests/{itineraryRequest}/edit', 'ItineraryRequestController@edit');
        Route::patch('/hris/pages/employees/itineraryRequests/update/{itineraryRequest}', 'ItineraryRequestController@update');
        Route::get('/hris/pages/employees/itineraryRequests/updateStatus/{status}/{itineraryRequest}', 'ItineraryRequestController@updateStatus');
        //delete
        Route::delete('/hris/pages/employees/itineraryRequests/delete/{itineraryRequest}', 'ItineraryRequestController@destroy');
        //show
        Route::get('/hris/pages/employees/itineraryRequests/{itineraryRequest}/show', 'ItineraryRequestController@show');
        //download
        Route::get('/hris/pages/employees/itineraryRequests/download/{attachment}/{itineraryRequest}', 'ItineraryRequestController@download');

        // EXCEL IMPORT / EXPORT
        Route::get('/hris/pages/employees/employee/table', 'EmployeeController@table');
        Route::post('/hris/pages/employees/employee/import', 'EmployeeController@import');
        Route::get('/hris/pages/employees/employee/download', 'EmployeeController@export');

        
    Route::group(['middleware' => 'CheckPermission:employees'], function () {
        // GET AJAX DATA FOR SUPERVISOR
        Route::post('/hris/pages/employees/employee/getSupervisor', 'EmployeeController@renderSupervisor')->name('getSupervisor.fetch');

        Route::get('/hris/pages/employees/employee/index', 'EmployeeController@index');
        Route::get('/hris/pages/employees/employee/create', 'EmployeeController@create');
        Route::post('/hris/pages/employees/employee', 'EmployeeController@store');
        //edit
        Route::get('/hris/pages/employees/employee/{employee}/edit', 'EmployeeController@edit');
        Route::patch('/hris/pages/employees/employee/update/{employee}', 'EmployeeController@update');
        //show
        Route::get('/hris/pages/employees/employee/{employee}', 'EmployeeController@show');
        //delete
        Route::delete('/hris/pages/employees/employee/delete/{employee}', 'EmployeeController@destroy');

       

        // DOCUMENT MANAGEMENT
        // COMPANY DOCUMENTS
        Route::get('/hris/pages/employees/documents/companyDocuments/index', 'CompanyDocumentController@index');
        Route::get('/hris/pages/employees/documents/companyDocuments/create', 'CompanyDocumentController@create');
        Route::post('/hris/pages/employees/documents/companyDocuments', 'CompanyDocumentController@store');
        //edit
        Route::get('/hris/pages/employees/documents/companyDocuments/{document}/edit', 'CompanyDocumentController@edit')->name('editCompanyDocument');
        Route::patch('/hris/pages/employees/documents/companyDocuments/update/{document}', 'CompanyDocumentController@update');
        //delete
        Route::delete('/hris/pages/employees/documents/companyDocuments/delete/{document}', 'CompanyDocumentController@destroy');
        // GET AJAX DATA FOR EMPLOYEE
        Route::post('/hris/pages/employees/documents/companyDocuments/getEmployee', 'CompanyDocumentController@renderEmployee')->name('getEmployee.fetch');
        // DOCUMENT TYPES
        Route::get('/hris/pages/employees/documents/types/index', 'DocumentTypeController@index');
        Route::get('/hris/pages/employees/documents/types/create', 'DocumentTypeController@create');
        Route::post('/hris/pages/employees/documents/types', 'DocumentTypeController@store');
        //edit
        Route::get('/hris/pages/employees/documents/types/{type}/edit', 'DocumentTypeController@edit');
        Route::patch('/hris/pages/employees/documents/types/update/{type}', 'DocumentTypeController@update');
        //delete
        Route::delete('/hris/pages/employees/documents/types/delete/{type}', 'DocumentTypeController@destroy');
        // EMPLOYEE DOCUMENTS
        Route::get('/hris/pages/employees/documents/employeeDocuments/index', 'EmployeeDocumentController@index');
        Route::get('/hris/pages/employees/documents/employeeDocuments/create', 'EmployeeDocumentController@create');
        Route::post('/hris/pages/employees/documents/employeeDocuments', 'EmployeeDocumentController@store');
        //edit
        Route::get('/hris/pages/employees/documents/employeeDocuments/{document}/edit', 'EmployeeDocumentController@edit');
        Route::patch('/hris/pages/employees/documents/employeeDocuments/update/{document}', 'EmployeeDocumentController@update');
        //delete
        Route::delete('/hris/pages/employees/documents/employeeDocuments/delete/{document}', 'EmployeeDocumentController@destroy');
    });

    /* BENEFITS PAGE */
    Route::get('/hris/pages/recruitment/recruitmentSetup/benefits/index', 'BenefitController@index');
    /* ADD BENEFIT */
    Route::get('/hris/pages/recruitment/recruitmentSetup/benefits/create', 'BenefitController@create');
    Route::post('/hris/pages/recruitment/recruitmentSetup/benefits', 'BenefitController@store');
    /* EDIT BENEFIT */
    Route::get('/hris/pages/recruitment/recruitmentSetup/benefits/{benefit}/edit', 'BenefitController@edit');
    /* UPDATE BENEFIT */
    Route::patch('/hris/pages/recruitment/recruitmentSetup/benefits/update/{benefit}', 'BenefitController@update');
    /* DELETE BENEFIT */
    Route::delete('/hris/pages/recruitment/recruitmentSetup/benefits/delete/{benefit}', 'BenefitController@destroy');


    /* EMPLOYMENT TYPES PAGE */
    Route::get('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index', 'EmploymentTypeController@index');
    /* ADD EMPLOYMENT TYPE */
    Route::get('/hris/pages/recruitment/recruitmentSetup/employmentTypes/create', 'EmploymentTypeController@create');
    Route::post('/hris/pages/recruitment/recruitmentSetup/employmentTypes', 'EmploymentTypeController@store');
    /* EDIT EMPLOYMENT TYPE */
    Route::get('/hris/pages/recruitment/recruitmentSetup/employmentTypes/{employmentType}/edit', 'EmploymentTypeController@edit');
    /* UPDATE EMPLOYMENT TYPE */
    Route::patch('/hris/pages/recruitment/recruitmentSetup/employmentTypes/update/{employmentType}', 'EmploymentTypeController@update');
    /* DELETE EMPLOYMENT TYPE */
    Route::delete('/hris/pages/recruitment/recruitmentSetup/employmentTypes/delete/{employmentType}', 'EmploymentTypeController@destroy');

    /* EDUCATION LEVELS PAGE */
    Route::get('/hris/pages/recruitment/recruitmentSetup/educationLevels/index', 'EducationLevelController@index');
    /* ADD EDUCATION LEVEL */
    Route::get('/hris/pages/recruitment/recruitmentSetup/educationLevels/create', 'EducationLevelController@create');
    Route::post('/hris/pages/recruitment/recruitmentSetup/educationLevels', 'EducationLevelController@store');
    /* EDIT EDUCATION LEVEL */
    Route::get('/hris/pages/recruitment/recruitmentSetup/educationLevels/{educationLevel}/edit', 'EducationLevelController@edit');
    /* UPDATE EDUCATION LEVEL */
    Route::patch('/hris/pages/recruitment/recruitmentSetup/educationLevels/update/{educationLevel}', 'EducationLevelController@update');
    /* DELETE EDUCATION LEVEL */
    Route::delete('/hris/pages/recruitment/recruitmentSetup/educationLevels/delete/{educationLevel}', 'EducationLevelController@destroy');

    /* EXPERIENCE LEVELS PAGE */
    Route::get('/hris/pages/recruitment/recruitmentSetup/experienceLevels/index', 'ExperienceLevelController@index');
    /* ADD EXPERIENCE LEVEL */
    Route::get('/hris/pages/recruitment/recruitmentSetup/experienceLevels/create', 'ExperienceLevelController@create');
    Route::post('/hris/pages/recruitment/recruitmentSetup/experienceLevels', 'ExperienceLevelController@store');
    /* EDIT EXPERIENCE LEVEL */
    Route::get('/hris/pages/recruitment/recruitmentSetup/experienceLevels/{experienceLevel}/edit', 'ExperienceLevelController@edit');
    /* UPDATE EXPERIENCE LEVEL */
    Route::patch('/hris/pages/recruitment/recruitmentSetup/experienceLevels/update/{experienceLevel}', 'ExperienceLevelController@update');
    /* DELETE EXPERIENCE LEVEL */
    Route::delete('/hris/pages/recruitment/recruitmentSetup/experienceLevels/delete/{experienceLevel}', 'ExperienceLevelController@destroy');

    /* JOB FUNCTIONS PAGE */
    Route::get('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index', 'JobFunctionController@index');
    /* ADD JOB FUNCTION */
    Route::get('/hris/pages/recruitment/recruitmentSetup/jobFunctions/create', 'JobFunctionController@create');
    Route::post('/hris/pages/recruitment/recruitmentSetup/jobFunctions', 'JobFunctionController@store');
    /* EDIT JOB FUNCTION */
    Route::get('/hris/pages/recruitment/recruitmentSetup/jobFunctions/{jobFunction}/edit', 'JobFunctionController@edit');
    /* UPDATE JOB FUNCTION */
    Route::patch('/hris/pages/recruitment/recruitmentSetup/jobFunctions/update/{jobFunction}', 'JobFunctionController@update');
    /* DELETE JOB FUNCTION */
    Route::delete('/hris/pages/recruitment/recruitmentSetup/jobFunctions/delete/{jobFunction}', 'JobFunctionController@destroy');

    /* JOB POSITIONS PAGE */
    Route::get('/hris/pages/recruitment/jobPositions/index', 'JobPositionController@index');
    /* ADD JOB POSITION */
    Route::get('/hris/pages/recruitment/jobPositions/create', 'JobPositionController@create');
    Route::post('/hris/pages/recruitment/jobPositions', 'JobPositionController@store');
    /* EDIT JOB POSITION */
    Route::get('/hris/pages/recruitment/jobPositions/{jobPosition}/edit', 'JobPositionController@edit');
    /* UPDATE JOB POSITION */
    Route::patch('/hris/pages/recruitment/jobPositions/update/{jobPosition}', 'JobPositionController@update');
    /* DELETE JOB POSITION */
    Route::delete('/hris/pages/recruitment/jobPositions/delete/{jobPosition}', 'JobPositionController@destroy');


    /* CANDIDATES PAGE */
    Route::get('/hris/pages/recruitment/candidates/index', 'CandidateController@index');
    /* ADD CANDIDATE */
    Route::get('/hris/pages/recruitment/candidates/create', 'CandidateController@create');
    Route::post('/hris/pages/recruitment/candidates', 'CandidateController@store');
    /* EDIT CANDIDATE */
    Route::get('/hris/pages/recruitment/candidates/{candidate}/edit', 'CandidateController@edit');
    /* UPDATE CANDIDATE */
    Route::patch('/hris/pages/recruitment/candidates/update/{candidate}', 'CandidateController@update');
    /* DELETE CANDIDATE */
    Route::delete('/hris/pages/recruitment/candidates/delete/{candidate}', 'CandidateController@destroy');

    /* TIME MANAGEMENT */

    /* DAILY TIME RECORDS */
    Route::get('/hris/pagestime/dailyTimeRecords/getDtr', 'DailyTimeRecordController@getEmployeeAttendance')->name('getDtr.fetch');
    Route::post('/hris/pagestime/dailyTimeRecords/getMonth', 'DailyTimeRecordController@getEmployeeAttendance')->name('getMonth.fetch');
    Route::get('/hris/pages/time/dailyTimeRecords/index', 'DailyTimeRecordController@index');
    /* WORKSHIFT MANAGEMENT */
    Route::get('/hris/pages/time/workshiftManagement/index', 'WorkShiftManagementController@index');
    /* ADD */
    Route::get('/hris/pages/time/workshiftManagement/create', 'WorkShiftManagementController@create');
    Route::post('/hris/pages/time/workshiftManagement', 'WorkShiftManagementController@store');
    /* UPDATE */
    Route::get('/hris/pages/time/workshiftManagement/{work_shift}/edit', 'WorkShiftManagementController@edit');
    Route::patch('/hris/pages/time/workshiftManagement/update/{work_shift}', 'WorkShiftManagementController@update');
    /* DELETE */
    Route::delete('/hris/pages/time/workshiftManagement/delete/{work_shift}', 'WorkShiftManagementController@destroy');

    /* WORKSHIFT ASSIGNMENT */
    Route::get('/hris/pages/time/workshiftAssignment/index', 'WorkShiftAssignmentController@index');
    /* ADD */
    Route::get('/hris/pages/time/workshiftAssignment/create', 'WorkShiftAssignmentController@create');
    Route::post('/hris/pages/time/workshiftAssignment', 'WorkShiftAssignmentController@store');
    /* UPDATE */
    Route::get('/hris/pages/time/workshiftAssignment/{workshift_assignment}/edit', 'WorkShiftAssignmentController@edit');
    Route::patch('/hris/pages/time/workshiftAssignment/update/{workshift_assignment}', 'WorkShiftAssignmentController@update');
    /* DELETE */
    Route::delete('/hris/pages/time/workshiftAssignment/delete/{workshift_assignment}', 'WorkShiftAssignmentController@destroy');

    /* ATTENDANCES PAGE */
    Route::get('/hris/pages/time/attendances/index', 'AttendanceController@index');
    /* PUNCH IN */
    Route::post('/hris/pages/time/attendances', 'AttendanceController@store');
    /* PUNCH OUT */
    Route::patch('/hris/pages/time/attendances/punchout/{attendance}', 'AttendanceController@punchout');

    /* OVERTIME REQUEST */

    Route::get('/hris/pages/time/overtime/index', 'OvertimeController@index');

    /* ADD */
    Route::get('/hris/pages/time/overtime/create', 'OvertimeController@create');
    Route::post('/hris/pages/time/overtime', 'OvertimeController@store');

    /* EDIT STATUS */
    Route::get('/hris/pages/time/overtime/{status}/{overtime}/status', 'OvertimeController@status');

    /* UPDATE */
    Route::get('/hris/pages/time/overtime/{overtime}/edit', 'OvertimeController@edit');
    Route::patch('/hris/pages/time/overtime/update/{overtime}', 'OvertimeController@update');
    Route::get('/hris/pages/time/overtime/{status}/{overtime}/edit', 'OvertimeController@editStatus')->name('editStatus');
    Route::patch('/hris/pages/time/overtime/update/{status}/{overtime}', 'OvertimeController@updateStatus');

    /* DELETE */
    Route::delete('/hris/pages/time/overtime/delete/{overtime}', 'OvertimeController@destroy');

    /* SHOW */
    Route::get('/hris/pages/time/overtime/{overtime}/show', 'OvertimeController@show');

    /* AJAX */
    Route::post('/hris/pages/time/overtime/getEmployeeOT', 'OvertimeController@renderEmployee')->name('getEmployeeOT.fetch');

    // EXPORT EXCEL FILE

    Route::get('/hris/pages/time/overtime/table', 'OvertimeController@table');
    Route::post('/hris/pages/time/overtime/download', 'ExportController@overtimeExport');
    

    //PERSONAL INFORMATION
    
    Route::get('/hris/pages/personalInformation/profile/index', 'PersonalInformationController@index');
    /* UPDATE */
    Route::get('/hris/pages/personalInformation/profile/{id}/edit', 'PersonalInformationController@edit');
    Route::patch('/hris/pages/personalInformation/profile/update/{employee}', 'PersonalInformationController@update');
    Route::get('/hris/pages/personalInformation/profile/changePass', 'PersonalInformationController@changePass');

    //EMPLOYEE SKILL PAGE
    Route::get('/hris/pages/personalInformation/skills/index', 'EmployeeSkillController@index');
    /* ADD */
    Route::get('/hris/pages/personalInformation/skills/create', 'EmployeeSkillController@create');
    Route::post('/hris/pages/personalInformation/skills', 'EmployeeSkillController@store');
    /* UPDATE */
    Route::get('/hris/pages/personalInformation/skills/{employeeSkill}/edit', 'EmployeeSkillController@edit');
    Route::patch('/hris/pages/personalInformation/skills/update/{employeeSkill}', 'EmployeeSkillController@update');
    /* DELETE */
    Route::delete('/hris/pages/personalInformation/skills/delete/{employeeSkill}', 'EmployeeSkillController@destroy');

    //EMPLOYEE EDUCATION PAGE
    Route::get('/hris/pages/personalInformation/educations/index', 'EmployeeEducationController@index');
    /* ADD */
    Route::get('/hris/pages/personalInformation/educations/create', 'EmployeeEducationController@create');
    Route::post('/hris/pages/personalInformation/educations', 'EmployeeEducationController@store');
    /* UPDATE */
    Route::get('/hris/pages/personalInformation/educations/{employeeEducation}/edit', 'EmployeeEducationController@edit');
    Route::patch('/hris/pages/personalInformation/educations/update/{employeeEducation}', 'EmployeeEducationController@update');
    /* DELETE */
    Route::delete('/hris/pages/personalInformation/educations/delete/{employeeEducation}', 'EmployeeEducationController@destroy');

    //EMPLOYEE CERTIFICATION PAGE
    Route::get('/hris/pages/personalInformation/certifications/index', 'EmployeeCertificationController@index');
    /* ADD */
    Route::get('/hris/pages/personalInformation/certifications/create', 'EmployeeCertificationController@create');
    Route::post('/hris/pages/personalInformation/certifications', 'EmployeeCertificationController@store');
    /* UPDATE */
    Route::get('/hris/pages/personalInformation/certifications/{employeeCertification}/edit', 'EmployeeCertificationController@edit');
    Route::patch('/hris/pages/personalInformation/certifications/update/{employeeCertification}', 'EmployeeCertificationController@update');
    /* DELETE */
    Route::delete('/hris/pages/personalInformation/certifications/delete/{employeeCertification}', 'EmployeeCertificationController@destroy');

    //EMPLOYEE LANGUAGES PAGE
    Route::get('/hris/pages/personalInformation/languages/index', 'EmployeeLanguageController@index');
    /* ADD */
    Route::get('/hris/pages/personalInformation/languages/create', 'EmployeeLanguageController@create');
    Route::post('/hris/pages/personalInformation/languages', 'EmployeeLanguageController@store');
    /* UPDATE */
    Route::get('/hris/pages/personalInformation/languages/{employeeLanguage}/edit', 'EmployeeLanguageController@edit');
    Route::patch('/hris/pages/personalInformation/languages/update/{employeeLanguage}', 'EmployeeLanguageController@update');
    /* DELETE */
    Route::delete('/hris/pages/personalInformation/languages/delete/{employeeLanguage}', 'EmployeeLanguageController@destroy');

    //EMPLOYEE DEPENDENTS PAGE
    Route::get('/hris/pages/personalInformation/dependents/index', 'DependentController@index');
    /* ADD */
    Route::get('/hris/pages/personalInformation/dependents/create', 'DependentController@create');
    Route::post('/hris/pages/personalInformation/dependents', 'DependentController@store');
    /* UPDATE */
    Route::get('/hris/pages/personalInformation/dependents/{dependent}/edit', 'DependentController@edit');
    Route::patch('/hris/pages/personalInformation/dependents/update/{dependent}', 'DependentController@update');
    /* DELETE */
    Route::delete('/hris/pages/personalInformation/dependents/delete/{dependent}', 'DependentController@destroy');

    //EMPLOYEE EMERGENCY CONTACTS PAGE
    Route::get('/hris/pages/personalInformation/emergencyContacts/index', 'EmergencyContactController@index');
    /* ADD */
    Route::get('/hris/pages/personalInformation/emergencyContacts/create', 'EmergencyContactController@create');
    Route::post('/hris/pages/personalInformation/emergencyContacts', 'EmergencyContactController@store');
    /* UPDATE */
    Route::get('/hris/pages/personalInformation/emergencyContacts/{emergency}/edit', 'EmergencyContactController@edit');
    Route::patch('/hris/pages/personalInformation/emergencyContacts/update/{emergency}', 'EmergencyContactController@update');
    /* DELETE */
    Route::delete('/hris/pages/personalInformation/emergencyContacts/delete/{emergency}', 'EmergencyContactController@destroy');

    //LEAVE MANAGEMENT
    Route::get('/hris/pages/leaveManagement/leaves/index', 'LeaveController@index');
    /* ADD */
    Route::get('/hris/pages/leaveManagement/leaves/create', 'LeaveController@create');
    Route::post('/hris/pages/leaveManagement/leaves', 'LeaveController@store');
    /* UPDATE */
    Route::get('/hris/pages/leaveManagement/leaves/{leaves}/edit', 'LeaveController@edit');
    Route::patch('/hris/pages/leaveManagement/leaves/update/{leaves}', 'LeaveController@update');

    /* APPROVE */
    Route::get('/hris/pages/leaveManagement/leaves/{leaves}/approve', 'LeaveController@approve');
    Route::patch('/hris/pages/leaveManagement/leaves/{leaves}/approveSubmit', 'LeaveController@approve_submit');
    /* DENY */
    Route::get('/hris/pages/leaveManagement/leaves/{leaves}/deny', 'LeaveController@deny');
    Route::patch('/hris/pages/leaveManagement/leaves/{leaves}/denySubmit', 'LeaveController@deny_submit');
    /* DELETE */
    Route::delete('/hris/pages/leaveManagement/leaves/delete/{leave}', 'LeaveController@destroy');

    // LEAVE ENTITLEMENT
    Route::get('/hris/pages/leaveManagement/leaveEntitlement/index', 'LeaveEntitlementController@index');

    // LEAVE Calendar
    Route::get('/hris/pages/leaveManagement/leaveCalendar/index', 'leaveCalendarController@index');

    // TRAINING MANAGEMENT

    // MY TRAINING SESSIONS
    Route::get('/hris/pages/training/myTraining/index', 'EmployeeTrainingSessionController@myTraining');
    // SIGN UP
    Route::get('/hris/pages/training/myTraining/{employeeTrainingSession}/signup', 'EmployeeTrainingSessionController@signup');

    // NOT ATTENDED
    Route::get('/hris/pages/training/myTraining/{employeeTrainingSession}/notAttended', 'EmployeeTrainingSessionController@notAttended');

    // COMPLETED
    Route::get('/hris/pages/training/myTraining/{employeeTrainingSession}/complete', 'EmployeeTrainingSessionController@completedForm');
    Route::patch('/hris/pages/training/myTraining/{employeeTrainingSession}/completed', 'EmployeeTrainingSessionController@completed');
    Route::get('/hris/pages/training/myTraining/download/{employeeTrainingSession}', 'EmployeeTrainingSessionController@completeDownload');

    // SHOW
     Route::get('/hris/pages/training/myTraining/{employeeTrainingSession}/show', 'EmployeeTrainingSessionController@showTraining');

    // COORDINATED
    Route::get('/hris/pages/training/coordinated/index', 'EmployeeTrainingSessionController@coordinated');
    Route::get('/hris/pages/training/coordinated/{employeeTrainingSession}/show', 'EmployeeTrainingSessionController@showCoordinated');
    Route::get('/hris/pages/training/coordinated/download/{employeeTrainingSession}', 'EmployeeTrainingSessionController@coordinatedDownload');

    // STAFF DIRECTORY
    Route::get('/hris/pages/company/staffDirectory/index', 'StaffDirectoryController@index');

    // FILTER
    Route::post('/hris/pages/company/staffDirectory/filter', 'StaffDirectoryController@filterData');



    Route::get('/hris/', function () {
        return view('welcome');
    });
});
