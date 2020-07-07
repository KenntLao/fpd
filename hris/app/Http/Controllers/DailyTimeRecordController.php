<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_workshift_assignment;
use App\hris_work_shift_management;
use App\hris_daily_time_record;
use App\hris_attendances;
use App\hris_employee;

class DailyTimeRecordController extends Controller
{
    //
    public function getEmployeeID()
    {
        $employee_id = $_SESSION['sys_id'];
        return hris_employee::where('id', $employee_id)->pluck('id')->first();
    }
    public function getEmployee(){
        $employee_id = $this->getEmployeeID();
        return hris_employee::where('id', $employee_id)->first();
    }

    public function getEmployeeWorkshift(){
        $employee_id = $this->getEmployeeID();
        return hris_workshift_assignment::where('employee_id',$employee_id)->pluck('workshift_id')->first();
    }
    public function getWorkshift(){
        $workshift_id = $this->getEmployeeWorkshift();
        return hris_work_shift_management::where('id',$workshift_id)->first();
    }

    public function getEmployeeAttendance()
    {
        $employee_id = $this->getEmployeeID();
        $employee_attendances = hris_attendances::where('employee_id', $employee_id)->get();
        $workshift = $this->getWorkshift();

        $attendances = [];
        foreach ($employee_attendances as $attendance) {
            // get attendance day
            $attendance_day = date('D', strtotime($attendance->time_in));
            switch($attendance_day){
                case "Sun":
                    // check if employee have monday shift
                    if($workshift->friday_shift == 1){
                        //check if employee attendance is in workshift range
                        $employee_attendance_date = $attendance->created_at->toDateString();
                        $employee_time_in = $attendance->time_in;
                        $employee_time_out = $attendance->time_out;
                        $workshift_time_in = $workshift->friday_time_in;
                        $workshift_time_out = $workshift->friday_time_out;
                        $attendance_range = $this->check_attendance_range($employee_time_in, $employee_time_out, $workshift_time_in, $workshift_time_out, $employee_attendance_date);

                        // if true
                        if($attendance_range !== 0) {
                            return $attendance_range;
                        }
                    }
                break;

            } 
           
        }

    }

    public function check_attendance_range($employee_time_in, $employee_time_out, $workshift_time_in, $workshift_time_out, $employee_attendance_date){
        $result = [];
        $employee_id = $this->getEmployeeID();
        $employee_time_in = date('h:i:s', strtotime($employee_time_in));
        $employee_time_out = date('h:i:s', strtotime($employee_time_out));
        $workshift_time_in = date('h:i:s', $workshift_time_in);
        $workshift_time_out = date('h:i:s', $workshift_time_out);
        // check if workshift time in rolls overnight
        if($workshift_time_in > $workshift_time_out) {
            //check if attendance is in workshift
            if($employee_time_in >= $workshift_time_in && $employee_time_out <= $workshift_time_out){
                $first_time_in = hris_attendances::where('employee_id', $employee_id)->whereDate('created_at', $employee_attendance_date)->whereTime('time_in','>=',$workshift_time_in)->oldest()->value('time_in');
                $latest_time_out = hris_attendances::where('employee_id', $employee_id)->whereDate('created_at', $employee_attendance_date)->whereTime('time_out', '<=', $workshift_time_out)->latest()->value('time_out');
                $collection = collect(['time_in' => $first_time_in, 'time_out' => $latest_time_out]);
                $result = $collection->all();
                return $result;
            }
        }
        // check time frame is within the same day
        else if($employee_time_in >= $workshift_time_in && $employee_time_out <= $workshift_time_out) {
            $first_time_in = hris_attendances::where('employee_id', $employee_id)->whereDate('created_at', $employee_attendance_date)->whereTime('time_in', '>=', $workshift_time_in)->oldest()->value('time_in');
            $latest_time_out = hris_attendances::where('employee_id', $employee_id)->whereDate('created_at', $employee_attendance_date)->whereTime('time_out', '<=', $workshift_time_out)->latest()->value('time_out');
            $collection = collect(['time_in' => $first_time_in, 'time_out' => $latest_time_out]);
            $result = $collection->all();
            return $result;
        }

    }

    public function index(hris_daily_time_record $dtr){
        $employee_attendance = $this->getEmployeeAttendance();
        $employee = $this->getEmployee();
        return view('pages.time.dailyTimeRecords.index', compact('employee_attendance','dtr','employee'));
    }
}
