<?php

namespace App\Http\Controllers;

use App\hris_attendances;
use App\hris_employee;
use Illuminate\Http\Request;

class MonitorAttendanceController extends Controller
{
    public function index()
    {
        if ($_SESSION['sys_account_mode'] == 'employee') {
            $sys_id = $_SESSION['sys_id'];
            $attendances = hris_employee::where('supervisor', $sys_id)->leftJoin('hris_attendances', 'hris_employees.id' ,'=', 'hris_attendances.employee_id')->first()->paginate(15);
            return view('pages.employees.monitorAttendance.index', compact('attendances'));
        } else {
            $attendances = hris_employee::leftJoin('hris_attendances', 'hris_employees.id', '=', 'hris_attendances.employee_id')->first()->paginate(15);
            return view('pages.employees.monitorAttendance.index', compact('attendances'));
        }
        
    }
    
}
