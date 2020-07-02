<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_daily_time_record;
use App\hris_attendances;
use App\hris_employee;

class DailyTimeRecordController extends Controller
{
    //
     public function getEmployeeAttendance(){
        $employee_id = $_SESSION['sys_id'];
        return hris_attendances::where('employee_id',$employee_id)->get();
    }
    public function getEmployee(){
        $employee_id = $_SESSION['sys_id'];
        return hris_employee::where('id', $employee_id)->first();
    }
    public function index(hris_daily_time_record $dtr){
        $employee = $this->getEmployee();
        $employee_attendances = $this->getEmployeeAttendance();
        return view('pages.time.dailyTimeRecords.index', compact('dtr','employee_attendances','employee'));
    }
}
