<?php

namespace App\Http\Controllers;

use App\hris_attendances;
use App\hris_employee;
use App\roles;
use Illuminate\Http\Request;

class MonitorAttendanceController extends Controller
{
    public function index()
    {
        if ($_SESSION['sys_account_mode'] == 'employee') {
            $sup_ids = roles::where('role_name','supervisor')->get('id')->toArray();
            $sup_id = implode(' ',$sup_ids[0]);
            $sys_id = $_SESSION['sys_id'];
            $current_user_level = hris_employee::where('id',$sys_id)->get('role_id')->toArray();
            $user_level = implode(' ',$current_user_level[0]);
            $user_level_arr = explode(',', $user_level);
            if(in_array($sup_id, $user_level_arr)) {
                $attendances = collect();
                $subordinates = hris_employee::where('supervisor', $sys_id)->get();

                foreach($subordinates as $subordinate) {
                    $emp_attendances = hris_employee::leftJoin('hris_attendances', 'hris_attendances.employee_id','=','hris_employees.id')->where('hris_employees.id',$subordinate->id)->first();
                    if($emp_attendances != NULL) {
                        $attendances->push($emp_attendances);
                    } else {
                        $attendances = collect();
                    }
                }
                return view('pages.employees.monitorAttendance.index', compact('attendances'));
            } else {
                return back()->withErrors('Only Supervisor are allowed to access this page.');
            }
            
        } else {
            $attendances = hris_employee::leftJoin('hris_attendances', 'hris_employees.id', '=', 'hris_attendances.employee_id')->first()->paginate(15);
            return view('pages.employees.monitorAttendance.index', compact('attendances'));
        }
        
    }
    public function show(hris_employee $employee){
        $emp_attendances = hris_attendances::where('employee_id',$employee->id)->leftJoin('hris_employees', 'hris_attendances.employee_id', '=', 'hris_employees.id')->orderBy('hris_attendances.created_at', 'desc')->paginate(10);
        return view('pages.employees.monitorAttendance.show', compact('emp_attendances'));
    }
    
}
