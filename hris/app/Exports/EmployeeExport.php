<?php

namespace App\Exports;

use App\hris_employee;
use App\hris_job_titles;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeExport implements FromView, ShouldAutoSize
{

    public function view(): View
    {
        $employees = hris_employee::all();
        return view('pages.employees.employee.table', [
            'employees' => $employees,
        ]);
    }
}
