<?php

namespace App\Exports;

use App\hris_attendances;
use App\hris_employee;
use App\hris_work_shift_management;
use App\hris_workshift_assignment;
use App\hris_job_titles;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AttendanceExport implements FromView, ShouldAutoSize
{
    
    public function __construct($date_from, $date_to)
    {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    
    public function view(): View
    {
        
        // convert date from and to - Ymd
        $from = date("Ymd",strtotime($this->date_from));
        $to = date("Ymd", strtotime($this->date_to));
        // get all employees & workshift assigned based on date provided
        $employees = hris_employee::leftJoin('hris_workshift_assignments', 'hris_workshift_assignments.employee_id', '=', 'hris_employees.id')->where('hris_workshift_assignments.date_from', '<=', $from)->where('hris_workshift_assignments.date_to', '>=', $to)->get();

        $date_from = $this->date_from;
        $date_to = $this->date_to;

        return view('pages.employees.monitorAttendance.export-attendance', compact('employees','date_from','date_to'));
    }
}
