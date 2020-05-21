<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/pages/admin/company/index', 'CompanyController@index');
/* ADD COMPANY STRUCTURE */
Route::get('/pages/admin/company/create', 'CompanyController@create');
Route::post('/pages/admin/company', 'CompanyController@store');
/* EDIT COMPANY STRUCTURE */
Route::get('/pages/admin/company/{company}/edit', 'CompanyController@edit');
/* UPDATE COMPANY STRUCTURE */
Route::patch('/pages/admin/company/update/{company}', 'CompanyController@update');
/* DELETE COMPANY STRUCTURE */
Route::delete('/pages/admin/company/delete/{company}', 'CompanyController@destroy');

/* JOB DETAILS SETUP */

/* JOB TITLES PAGE */
Route::get('/pages/admin/jobDetails/jobTitles/index', 'JobTitleController@index');
/* ADD JOB TITLES */
Route::get('/pages/admin/jobDetails/jobTitles/create', 'JobTitleController@create');
Route::post('/pages/admin/jobDetails/jobTitles', 'JobTitleController@store');
/* EDIT JOB TITLES */
Route::get('/pages/admin/jobDetails/jobTitles/{jobTitle}/edit', 'JobTitleController@edit');
/* UPDATE JOB TITLES */
Route::patch('/pages/admin/jobDetails/jobTitles/update/{jobTitle}', 'JobTitleController@update');
/* DELETE JOB TITLES */
Route::delete('/pages/admin/jobDetails/jobTitles/delete/{jobTitle}', 'JobTitleController@destroy');

/* PAY GRADES */
Route::get('/pages/admin/jobDetails/payGrades/index', 'PayGradeController@index');
/* ADD PAY GRADES */
Route::get('/pages/admin/jobDetails/payGrades/create', 'PayGradeController@create');
Route::post('/pages/admin/jobDetails/payGrades', 'PayGradeController@store');
/* EDIT PAY GRADES */
Route::get('/pages/admin/jobDetails/payGrades/{payGrade}/edit', 'PayGradeController@edit');
/* UPDATE PAY GRADES */
Route::patch('/pages/admin/jobDetails/payGrades/update/{payGrade}', 'PayGradeController@update');
/* DELETE PAY GRADES */
Route::delete('/pages/admin/jobDetails/payGrades/delete/{payGrade}', 'PayGradeController@destroy');

/* EMPLOYMENT STATUS PAGE */
Route::get('/pages/admin/jobDetails/employmentStatuses/index', 'EmploymentStatusController@index');
/* ADD EMPLOYMENT STATUS */
Route::get('/pages/admin/jobDetails/employmentStatuses/create', 'EmploymentStatusController@create');
Route::post('/pages/admin/jobDetails/employmentStatuses', 'EmploymentStatusController@store');
/* EDIT EMPLOYMENT STATUS */
Route::get('/pages/admin/jobDetails/employmentStatuses/{employmentStatus}/edit', 'EmploymentStatusController@edit');
/* UPDATE EMPLOYMENT STATUS */
Route::patch('/pages/admin/jobDetails/employmentStatuses/update/{employmentStatus}', 'EmploymentStatusController@update');
/* DELETE EMPLOYMENT STATUS */
Route::delete('/pages/admin/jobDetails/employmentStatuses/delete/{employmentStatus}', 'EmploymentStatusController@destroy');

/* QUALIFICATIONS SETUP */

/* SKILLS PAGE */
Route::get('/pages/admin/qualifications/skills/index', 'SkillController@index');
/* ADD SKILLS */
Route::get('/pages/admin/qualifications/skills/create', 'SkillController@create');
Route::post('/pages/admin/qualifications/skills', 'SkillController@store');
/* EDIT SKILLS */
Route::get('/pages/admin/qualifications/skills/{skill}/edit', 'SkillController@edit');
/* UPDATE SKILLS */
Route::patch('/pages/admin/qualifications/skills/update/{skill}', 'SkillController@update');
/* DELETE SKILLS */
Route::delete('/pages/admin/qualifications/skills/delete/{skill}', 'SkillController@destroy');

/* EDUCATIONS PAGE */
Route::get('/pages/admin/qualifications/educations/index', 'EducationController@index');
/* ADD EDUCATIONS */
Route::get('/pages/admin/qualifications/educations/create', 'EducationController@create');
Route::post('/pages/admin/qualifications/educations', 'EducationController@store');
/* EDIT EDUCATIONS */
Route::get('/pages/admin/qualifications/educations/{education}/edit', 'EducationController@edit');
/* UPDATE EDUCATIONS */
Route::patch('/pages/admin/qualifications/educations/update/{education}', 'EducationController@update');
/* DELETE EDUCATIONS */
Route::delete('/pages/admin/qualifications/educations/delete/{education}', 'EducationController@destroy');

/* CERTIFICATIONS PAGE */
Route::get('/pages/admin/qualifications/certifications/index', 'CertificationController@index');
/* ADD CERTIFICATIONS */
Route::get('/pages/admin/qualifications/certifications/create', 'CertificationController@create');
Route::post('/pages/admin/qualifications/certifications', 'CertificationController@store');
/* EDIT CERTIFICATIONS */
Route::get('/pages/admin/qualifications/certifications/{certification}/edit', 'CertificationController@edit');
/* UPDATE CERTIFICATIONS */
Route::patch('/pages/admin/qualifications/certifications/update/{certification}', 'CertificationController@update');
/* DELETE CERTIFICATIONS */
Route::delete('/pages/admin/qualifications/certifications/delete/{certification}', 'CertificationController@destroy');

/* LANGUAGES PAGE */
Route::get('/pages/admin/qualifications/languages/index', 'LanguageController@index');
/* ADD LANGUAGES */
Route::get('/pages/admin/qualifications/languages/create', 'LanguageController@create');
Route::post('/pages/admin/qualifications/languages', 'LanguageController@store');
/* EDIT LANGUAGES */
Route::get('/pages/admin/qualifications/languages/{language}/edit', 'LanguageController@edit');
/* UPDATE LANGUAGES */
Route::patch('/pages/admin/qualifications/languages/update/{language}', 'LanguageController@update');
/* DELETE LANGUAGES */
Route::delete('/pages/admin/qualifications/languages/delete/{language}', 'LanguageController@destroy');

/* TRAINING SETUP */

/* COURSES PAGE */
Route::get('/pages/admin/training/courses/index', 'CourseController@index');
/* ADD COURSES */
Route::get('/pages/admin/training/courses/create', 'CourseController@create');
Route::post('/pages/admin/training/courses', 'CourseController@store');
/* EDIT COURSES */
Route::get('/pages/admin/training/courses/{course}/edit', 'CourseController@edit');
/* UPDATE COURSES */
Route::patch('/pages/admin/training/courses/update/{course}', 'CourseController@update');
/* DELETE COURSES */
Route::delete('/pages/admin/training/courses/delete/{course}', 'CourseController@destroy');

/* EMPLOYEE TRAINING SESSIONS PAGE */
Route::get('/pages/admin/training/employeeTrainingSessions/index', 'EmployeeTrainingSessionController@index');
/* ADD EMPLOYEE TRAINING SESSIONS */
Route::get('/pages/admin/training/employeeTrainingSessions/create', 'EmployeeTrainingSessionController@create');
Route::post('/pages/admin/training/employeeTrainingSessions', 'EmployeeTrainingSessionController@store');
/* EDIT EMPLOYEE TRAINING SESSIONS */
Route::get('/pages/admin/training/employeeTrainingSessions/{employeeTrainingSession}/edit', 'EmployeeTrainingSessionController@edit');
/* UPDATE EMPLOYEE TRAINING SESSIONS */
Route::patch('/pages/admin/training/employeeTrainingSessions/update/{employeeTrainingSession}', 'EmployeeTrainingSessionController@update');
/* DELETE EMPLOYEE TRAINING SESSIONS */
Route::delete('/pages/admin/training/employeeTrainingSessions/delete/{employeeTrainingSession}', 'EmployeeTrainingSessionController@destroy');

/* TRAINING SESSIONS PAGE */
Route::get('/pages/admin/training/trainingSessions/index', 'TrainingSessionController@index');
/* ADD TRAINING SESSIONS */
Route::get('/pages/admin/training/trainingSessions/create', 'TrainingSessionController@create');
Route::post('/pages/admin/training/trainingSessions', 'TrainingSessionController@store');
/* EDIT TRAINING SESSIONS */
Route::get('/pages/admin/training/trainingSessions/{trainingSession}/edit', 'TrainingSessionController@edit');
/* UPDATE TRAINING SESSIONS */
Route::patch('/pages/admin/training/trainingSessions/update/{trainingSession}', 'TrainingSessionController@update');
/* DELETE TRAINING SESSIONS */
Route::delete('/pages/admin/training/trainingSessions/delete/{trainingSession}', 'TrainingSessionController@destroy');


/* RECRUITMENT SETUP PAGE */
Route::get('/pages/recruitment/recruitmentSetup/index', 'RecruitmentSetupController@index');

/* BENEFITS PAGE */
Route::get('/pages/recruitment/recruitmentSetup/benefits/index', 'BenefitController@index');
/* ADD BENEFIT */
Route::get('/pages/recruitment/recruitmentSetup/benefits/create', 'BenefitController@create');
Route::post('/pages/recruitment/recruitmentSetup/benefits', 'BenefitController@store');
/* EDIT BENEFIT */
Route::get('/pages/recruitment/recruitmentSetup/benefits/{benefit}/edit', 'BenefitController@edit');
/* UPDATE BENEFIT */
Route::patch('/pages/recruitment/recruitmentSetup/benefits/update/{benefit}', 'BenefitController@update');
/* DELETE BENEFIT */
Route::delete('/pages/recruitment/recruitmentSetup/benefits/delete/{benefit}', 'BenefitController@destroy');

/* EMPLOYMENT TYPES PAGE */
Route::get('/pages/recruitment/recruitmentSetup/employmentTypes/index', 'EmploymentTypeController@index');
/* ADD EMPLOYMENT TYPE */
Route::get('/pages/recruitment/recruitmentSetup/employmentTypes/create', 'EmploymentTypeController@create');
Route::post('/pages/recruitment/recruitmentSetup/employmentTypes', 'EmploymentTypeController@store');
/* EDIT EMPLOYMENT TYPE */
Route::get('/pages/recruitment/recruitmentSetup/employmentTypes/{employmentType}/edit', 'EmploymentTypeController@edit');
/* UPDATE EMPLOYMENT TYPE */
Route::patch('/pages/recruitment/recruitmentSetup/employmentTypes/update/{employmentType}', 'EmploymentTypeController@update');
/* DELETE EMPLOYMENT TYPE */
Route::delete('/pages/recruitment/recruitmentSetup/employmentTypes/delete/{employmentType}', 'EmploymentTypeController@destroy');

/* EDUCATION LEVELS PAGE */
Route::get('/pages/recruitment/recruitmentSetup/educationLevels/index', 'EducationLevelController@index');
/* ADD EDUCATION LEVEL */
Route::get('/pages/recruitment/recruitmentSetup/educationLevels/create', 'EducationLevelController@create');
Route::post('/pages/recruitment/recruitmentSetup/educationLevels', 'EducationLevelController@store');
/* EDIT EDUCATION LEVEL */
Route::get('/pages/recruitment/recruitmentSetup/educationLevels/{educationLevel}/edit', 'EducationLevelController@edit');
/* UPDATE EDUCATION LEVEL */
Route::patch('/pages/recruitment/recruitmentSetup/educationLevels/update/{educationLevel}', 'EducationLevelController@update');
/* DELETE EDUCATION LEVEL */
Route::delete('/pages/recruitment/recruitmentSetup/educationLevels/delete/{educationLevel}', 'EducationLevelController@destroy');

/* EXPERIENCE LEVELS PAGE */
Route::get('/pages/recruitment/recruitmentSetup/experienceLevels/index', 'ExperienceLevelController@index');
/* ADD EXPERIENCE LEVEL */
Route::get('/pages/recruitment/recruitmentSetup/experienceLevels/create', 'ExperienceLevelController@create');
Route::post('/pages/recruitment/recruitmentSetup/experienceLevels', 'ExperienceLevelController@store');
/* EDIT EXPERIENCE LEVEL */
Route::get('/pages/recruitment/recruitmentSetup/experienceLevels/{experienceLevel}/edit', 'ExperienceLevelController@edit');
/* UPDATE EXPERIENCE LEVEL */
Route::patch('/pages/recruitment/recruitmentSetup/experienceLevels/update/{experienceLevel}', 'ExperienceLevelController@update');
/* DELETE EXPERIENCE LEVEL */
Route::delete('/pages/recruitment/recruitmentSetup/experienceLevels/delete/{experienceLevel}', 'ExperienceLevelController@destroy');

/* JOB FUNCTIONS PAGE */
Route::get('/pages/recruitment/recruitmentSetup/jobFunctions/index', 'JobFunctionController@index');
/* ADD JOB FUNCTION */
Route::get('/pages/recruitment/recruitmentSetup/jobFunctions/create', 'JobFunctionController@create');
Route::post('/pages/recruitment/recruitmentSetup/jobFunctions', 'JobFunctionController@store');
/* EDIT JOB FUNCTION */
Route::get('/pages/recruitment/recruitmentSetup/jobFunctions/{jobFunction}/edit', 'JobFunctionController@edit');
/* UPDATE JOB FUNCTION */
Route::patch('/pages/recruitment/recruitmentSetup/jobFunctions/update/{jobFunction}', 'JobFunctionController@update');
/* DELETE JOB FUNCTION */
Route::delete('/pages/recruitment/recruitmentSetup/jobFunctions/delete/{jobFunction}', 'JobFunctionController@destroy');

/* JOB POSITIONS PAGE */
Route::get('/pages/recruitment/jobPositions/index', 'JobPositionController@index');
/* ADD JOB POSITION */
Route::get('/pages/recruitment/jobPositions/create', 'JobPositionController@create');
Route::post('/pages/recruitment/jobPositions', 'JobPositionController@store');
/* EDIT JOB POSITION */
Route::get('/pages/recruitment/jobPositions/{jobPosition}/edit', 'JobPositionController@edit');
/* UPDATE JOB POSITION */
Route::patch('/pages/recruitment/jobPositions/update/{jobPosition}', 'JobPositionController@update');
/* DELETE JOB POSITION */
Route::delete('/pages/recruitment/jobPositions/delete/{jobPosition}', 'JobPositionController@destroy');


/* CANDIDATES PAGE */
Route::get('/pages/recruitment/candidates/index', 'CandidateController@index');
/* ADD CANDIDATE */
Route::get('/pages/recruitment/candidates/create', 'CandidateController@create');
Route::post('/pages/recruitment/candidates', 'CandidateController@store');
/* EDIT CANDIDATE */
Route::get('/pages/recruitment/candidates/{candidate}/edit', 'CandidateController@edit');
/* UPDATE CANDIDATE */
Route::patch('/pages/recruitment/candidates/update/{candidate}', 'CandidateController@update');
/* DELETE CANDIDATE */
Route::delete('/pages/recruitment/candidates/delete/{candidate}', 'CandidateController@destroy');

Route::get('/', function () {
    return view('welcome');
});
