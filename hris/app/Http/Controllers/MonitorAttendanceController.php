<?php

namespace App\Http\Controllers;

use App\hris_attendances;
use Illuminate\Http\Request;

class MonitorAttendanceController extends Controller
{
    public function index()
    {
        if ($_SESSION['sys_account_mode'] == 'employee') {
            $attendances = hris_attendances::paginate(15);
            return view('pages.employees.monitorAttendance.index', compact('attendances'));
        } else {
            $attendances = hris_attendances::paginate(15);
            return view('pages.employees.monitorAttendance.index', compact('attendances'));
        }
        
    }
}
