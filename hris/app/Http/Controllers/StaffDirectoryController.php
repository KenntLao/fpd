<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_employee;
use App\hris_company_structures;
use App\hris_job_titles;

class StaffDirectoryController extends Controller
{

    public function index()
    {
        $employees = hris_employee::orderBy('lastname', 'ASC')->paginate(12);
        $departments = hris_company_structures::all();
        $jobTitles = hris_job_titles::all();
        return view('pages.company.staffDirectory.index', compact('employees', 'departments', 'jobTitles'));
    }

    public function filterData()
    {
        if ( request('department_id') == 0 AND request('job_title_id') == 0 ) {
            return redirect('/hris/pages/company/staffDirectory/index');
        }

        if ( request('department_id') == 0 AND request('job_title_id') != 0 ) {
            $employees = hris_employee::where('job_title_id', request('job_title_id'))->orderBy('lastname', 'ASC')->paginate(10);
            $departments = hris_company_structures::all();
            $jobTitles = hris_job_titles::all();
            return view('pages.company.staffDirectory.index', compact('employees', 'departments', 'jobTitles'));
        }

        if ( request('department_id') != 0 AND request('job_title_id') == 0 ) {
            $employees = hris_employee::where('department_id', request('department_id'))->orderBy('lastname', 'ASC')->paginate(10);
            $departments = hris_company_structures::all();
            $jobTitles = hris_job_titles::all();
            return view('pages.company.staffDirectory.index', compact('employees', 'departments', 'jobTitles'));
        }

        if ( request('department_id') != 0 AND request('job_title_id') != 0 ) {
            $employees = hris_employee::where('job_title_id', request('job_title_id'))->where('department_id', request('department_id'))->orderBy('lastname', 'ASC')->paginate(10);
            $departments = hris_company_structures::all();
            $jobTitles = hris_job_titles::all();
            return view('pages.company.staffDirectory.index', compact('employees', 'departments', 'jobTitles'));
        }
    }

}
