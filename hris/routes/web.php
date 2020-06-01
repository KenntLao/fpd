<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserID;
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
    Route::get('/hris/pages/admin/leave/holidays/index', 'HolidayController@index');
    /* ADD LEAVE RULES */
    Route::get('/hris/pages/admin/leave/holidays/create', 'HolidayController@create');
    Route::post('/hris/pages/admin/leave/holidays', 'HolidayController@store');
    /* EDIT LEAVE RULES */
    Route::get('/hris/pages/admin/leave/holidays/{holiday}/edit', 'HolidayController@edit');
    /* UPDATE LEAVE RULES */
    Route::patch('/hris/pages/admin/leave/holidays/update/{holiday}', 'HolidayController@update');
    /* DELETE LEAVE RULES */
    Route::delete('/hris/pages/admin/leave/holidays/delete/{holiday}', 'HolidayController@destroy');

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
    /* UPDATE EMPLOYEE EXPENSES STATUS*/
    Route::patch('/hris/pages/admin/benefits/employeeExpenses/updateStatus/{employeeExpense}', 'EmployeeExpenseController@updateStatus');
    /* DELETE EMPLOYEE EXPENSES */
    Route::delete('/hris/pages/admin/benefits/employeeExpenses/delete/{employeeExpense}', 'EmployeeExpenseController@destroy');

    /* EMPLOYEE MANAGEMENT */
    Route::get('/hris/pages/employees/employee/index', 'EmployeeController@index');
    Route::get('/hris/pages/employees/employee/create', 'EmployeeController@create');

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
    /* PROJECT PAGE */
    Route::get('/hris/pages/time/timeProjects/index', 'TimeProjectController@index');
    /* ADD PROJECT */
    Route::get('/hris/pages/time/timeProjects/create', 'TimeProjectController@create');
    Route::post('/hris/pages/time/timeProjects', 'TimeProjectController@store');
    /* EDIT PROJECT */
    Route::get('/hris/pages/time/timeProjects/{timeProject}/edit', 'TimeProjectController@edit');
    /* UPDATE PROJECT */
    Route::patch('/hris/pages/time/timeProjects/update/{timeProject}', 'TimeProjectController@update');
    /* DELETE PROJECT */
    Route::delete('/hris/pages/time/timeProjects/delete/{timeProject}', 'TimeProjectController@destroy');

    /* ATTENDANCES PAGE */
    Route::get('/hris/pages/time/attendances/index', 'AttendanceController@index');
    /* ADD ATTENDANCES */
    Route::post('/hris/pages/time/attendances', 'AttendanceController@store');
    /* UPDATE ATTENDANCES */
    Route::patch('/hris/pages/time/attendances/update/{attendance}', 'AttendanceController@update');
    /* DELETE ATTENDANCES */
    Route::delete('/hris/pages/time/attendances/delete/{attendance}', 'AttendanceController@destroy');

    /* TIME SHEETS PAGE */
    Route::get('/hris/pages/time/timeSheets/index', 'TimeSheetController@index');

    /* ATTENDANCE SHEETS PAGE */
    Route::get('/hris/pages/time/attendanceSheets/index', 'AttendanceSheetController@index');

    /* OVERTIME REQUESTS PAGE */
    Route::get('/hris/pages/time/overtimeRequests/index', 'OvertimeRequestController@index');


    Route::get('/hris/', function () {
        return view('welcome');
    });
});
