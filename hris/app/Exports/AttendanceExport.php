<?php

namespace App\Exports;

use App\hris_attendances;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceExport implements FromView
{
    
    public function __construct($date_from, $date_to)
    {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }
    public function view(): View
    {
        return view('pages.employees.monitorAttendance.export-attendance', [
            'attendances' => hris_attendances::all()
        ]);
    }
}
