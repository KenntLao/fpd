<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_workshift_assignment;
use App\hris_work_shift_management;
use App\hris_daily_time_record;
use App\hris_attendances;
use App\hris_employee;
use App\hris_overtime;

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

    public function getEmployeeWorkshiftID(){
        $employee_id = $this->getEmployeeID();
        return hris_workshift_assignment::where('employee_id',$employee_id)->get('workshift_id');
    }
    public function getEmployeeWorkShift(){
        $employee_id = $this->getEmployeeID();
        return hris_workshift_assignment::where('employee_id',$employee_id)->leftJoin('hris_work_shift_managements', 'hris_workshift_assignments.workshift_id', '=', 'hris_work_shift_managements.id')->get();
    }
    public function getEmployeeAttendance(Request $request)
    {

        $employee_id = $this->getEmployeeID();

        // current month
        if($request->monthValue){
            $current_month = $request->monthValue;
        }else {
            $current_month = date('Ym');
        }

        // days count in month
        $last_day = date('t', $current_month . '01');
        $current_month_length = $current_month . $last_day;

        // get FROM and TO date range for getting TIME IN SESSIONS
        $lastday_lastmonth = strtotime('last day of previous month 12 am');
        $firstday_nextmonth = strtotime('first day of next month 11:59 pm');

        // TIME IN SESSIONS based on FROM and TO
        $employee_attendances = hris_attendances::where('employee_id', $employee_id)->where('time_in', '>=', $lastday_lastmonth)->where('time_out', '<=', $firstday_nextmonth)->get();

        // OVERTIME FOR THIS MONTH
        
        $employee_overtimes = hris_overtime::where('employee_id', $employee_id)->where('ot_date', '<=', $current_month_length)->where('status',1)->get();

        // get ASSIGN WORKSHIFTS
        $employee_assigned_workshifts = $this->getEmployeeWorkShift();

        // LOOP DAYS IN MONTH
        for ($day = 1; $day <= $last_day; $day++) {

            // add 0 at beginning of single digit
            $day = strlen($day) == 1 ? '0' . $day : $day;

            // get date_code
            $date_code = $current_month . $day;

            // get date_code day
            $date_code_day = strtolower(date('l', strtotime($date_code)));

            $counter = 0;

            $day_shift = 0;
            $day_time_in = 0;
            $day_time_out = 0;

            foreach ($employee_assigned_workshifts as $employee_assigned_workshift) {

                // GET WORKSHIFT DURATION FROM - TO
                $ws_date_from = $employee_assigned_workshift->date_from;
                $ws_date_to = $employee_assigned_workshift->date_to;

                // CHECK CURRENT WORKSHIFT
                if ($date_code >= $ws_date_from && $ws_date_from <= $ws_date_to) {
                    $day_shift = $employee_assigned_workshift->{$date_code_day . '_shift'};
                    $day_time_in = $employee_assigned_workshift->{$date_code_day . '_time_in'};
                    $day_time_out = $employee_assigned_workshift->{$date_code_day . '_time_out'};
                    break;
                }
            }

            // check if rest day or not
            if (!$day_shift) {
                $day_attendance_time_in = 'Rest Day';
                $day_attendance_time_out = 'Rest Day';
            } else {

                // define array for emp time in sessions
                
                $day_sessions_arr = array();


                // convert time in/out to EPOCH
                $day_time_in = strtotime($date_code.' '.$day_time_in);
                $date_code = date('Ymd', strtotime($date_code . ' -1 days'));

                // check if workshift is graveyard
                if($day_time_in > $day_time_out) {
                    $date_code = date('Ymd',strtotime($date_code.' +1 days'));
                    $day_time_out = strtotime($date_code.' '.$day_time_out);
                } else {
                    $day_time_out = strtotime($date_code.' '.$day_time_out);
                }
                

                // compare employee time in sessions to workshift schedule
                foreach ($employee_attendances as $i => $employee_attendance) {
                    $session_time_in = $employee_attendance->time_in;
                    $session_time_out = $employee_attendance->time_out;

                    // case 1 - normal
                    if (
                        $session_time_in <= $day_time_in &&
                        $session_time_out >= $day_time_out
                    ) {
                        array_push($day_sessions_arr, $employee_attendances[$i]);
                    }

                    // case 2 - early out
                    if (
                        $session_time_in <= $day_time_in &&
                        $session_time_out > $day_time_in &&
                        $session_time_out <= $day_time_out
                    ) {
                        array_push($day_sessions_arr, $employee_attendances[$i]);
                    }

                    // case 3 - late
                    if (
                        $session_time_in > $day_time_in &&
                        $session_time_in < $day_time_out &&
                        $session_time_out >= $day_time_out
                    ) {
                        array_push($day_sessions_arr, $employee_attendances[$i]);
                    }

                    // case 4 - late and early out
                    if (
                        $session_time_in > $day_time_in &&
                        $session_time_out < $day_time_out
                    ) {
                        array_push($day_sessions_arr, $employee_attendances[$i]);
                    }
                }
                // get time in sessions
                // NO TIME IN FOR THE DAY
                if($day_sessions_arr == []){
                    $day_attendance_time_in = '-';
                    $day_attendance_time_out = '-';

                } else { // have time in
                    $day_attendance_time_in = $day_sessions_arr[0]['time_in'];
                    $day_attendance_time_out = $day_sessions_arr[count($day_sessions_arr) - 1]['time_out'];
                }
            }

            // GET MATCHING OVERTIME
            $emp_ot_arr = array();

            foreach($employee_overtimes as $employee_overtime) {
                    if($date_code == $employee_overtime->ot_date){
                        array_push($emp_ot_arr, $employee_overtime);
                    }
            }
            if($emp_ot_arr == []){
                $emp_ot_time_in = '-';
                $emp_ot_time_out = '-';
                $emp_ot_remarks = '-';
            } else {
                $emp_ot_time_in = substr_replace($emp_ot_arr[0]['ot_time_in'], ':', 2, 0);
                $emp_ot_time_out = substr_replace($emp_ot_arr[0]['ot_time_out'], ':', 2, 0);
                $emp_ot_remarks = $emp_ot_arr[0]['supervisor_remarks'];
            }

            $result = '';

            $attendance_date = date('Y M d', strtotime($date_code));
            $attendance_day = date('D', strtotime($date_code));

            if($day_attendance_time_in == 'Rest Day' && $day_attendance_time_out == 'Rest Day' || $day_attendance_time_in == '-' && $day_attendance_time_out == '-'){
                $attendance_time_in = $day_attendance_time_in;
                $attendance_time_out = $day_attendance_time_out;

            } else {
                $attendance_time_in = date('h:i:s', $day_attendance_time_in);
                $attendance_time_out = date('h:i:s', $day_attendance_time_out);
            }

            $result .= '<tr>
                            <td>' . date('Y M d', strtotime($date_code)) . '</td>
                            <td>' . date('D', strtotime($date_code)) . '</td>
                            <td>' . $attendance_time_in . '</td>
                            <td>' . $attendance_time_out . '</td>
                            <td>'. $emp_ot_time_in .'</td>
                            <td>'. $emp_ot_time_out .'</td>
                            <td>'. $emp_ot_remarks .'</td>
                        </tr>';
           echo $result . '<br>';
        }
    }
    
    /*public function getRenderedHours(){
        $attendances = $this->getEmployeeAttendance();
        $hours = 0;
        foreach($attendances as $attendance){
            $time_in = strtotime($attendance['time_in']);
            $time_out = strtotime($attendance['time_out']);

            $hours = abs($time_out - $time_in) / 3600;
        }
        return $hours;
    } */


    public function index(hris_daily_time_record $dtr){
        if($_SESSION['sys_account_mode'] == 'employee'){
            $employee = $this->getEmployee();
            $default_month = date('Ym');
            return view('pages.time.dailyTimeRecords.index', compact('default_month', 'dtr', 'employee'));
        }else {
            return back()->withErrors("You don't have access on this page");
        }
    }
}
