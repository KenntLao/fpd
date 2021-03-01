<table>
    <thead>
        <tr>
            <th>Employee No.</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Position</th>
            <th>Date</th>
            <th>Work Shift Time in</th>
            <th>Work Shift Time out</th>
            <th>Actual Time in</th>
            <th>Actual Time out</th>
            <th>Attendance Status</th>
        </tr>
    </thead>

    <tbody>


        @foreach($employees as $employee)
        <!-- $employee->id == workshift id , $employee->employee_id == employee id -->
        @php
            $begin = new DateTime($date_from);
            $end = new DateTime($date_to);
            if($employee->job_title_id != NULL) {
                $jobtitle_name = \App\hris_job_titles::where('id',$employee->job_title_id)->pluck('name')->first();
            } else {
                $jobtitle_name = 'N/A';
            }
            //GET ALL EMPLOYEE ATTENDANCES
            $employee_attendances = \App\hris_attendances::where('employee_id',$employee->employee_id)->where('time_in', '>=', strtotime($date_from))->where('time_out', '<=' , strtotime($date_to))->get();

            //GET EMPLOYEE WORKSHIFT
            $employee_workshift = \App\hris_work_shift_management::where('id',$employee->workshift_id)->first();

        @endphp
        @for($i = $begin; $i <= $end; $i->modify('+1 day'))
            @php
            $day_sessions_arr = array();
            //GET DATE DAY EX: MONDAY, TUESDAY
            $date_code = $i->format('Ymd');
            $date_code_day = strtolower($i->format('l'));

            @endphp

            <tr>
                <td>{{$employee->employee_number}}</td>
                <td>{{$employee->lastname}}</td>
                <td>{{$employee->firstname}}</td>
                <td>{{$employee->middlename}}</td>
                <td>{{$jobtitle_name}}</td>
                <td>{{$i->format("Y-m-d")}}</td>
                @if($employee_workshift->{$date_code_day.'_shift'} != 0)
                    @php
                        $employee_ws_time_in = $employee_workshift->{$date_code_day.'_time_in'};
                        $employee_ws_time_out = $employee_workshift->{$date_code_day.'_time_out'};
                    @endphp
                    <td>{{substr_replace($employee_ws_time_in, ':', 2, 0)}}</td>
                    <td>{{substr_replace($employee_ws_time_out, ':', 2, 0)}}</td>
                @else
                    <td>Rest Day</td>
                    <td>Rest Day</td>
                @endif

                @foreach($employee_attendances as $a => $attendance)
                    
                    @php
                        
                        // convert ws time in and out to epoch
                        $ws_time_in = strtotime($date_code.$employee_ws_time_in);
                        $ws_time_out = strtotime($date_code.$employee_ws_time_out);
                        // get attendance time in / time out
                        $session_time_in = $attendance->time_in;
                        $session_time_out = $attendance->time_out;
                    @endphp

                    @if($i->format("Y-m-d") == date("Y-m-d",$attendance->time_in))
                        <!-- Case 1 normal -->
                        @if($session_time_in <= $ws_time_in && $session_time_out >= $ws_time_out)
                            @php
                                array_push($day_sessions_arr, $employee_attendances[$a]);
                            @endphp
                        <!-- Case 2 Early Out -->
                        @elseif($session_time_in <= $ws_time_in && $session_time_out > $ws_time_in && $session_time_out <= $ws_time_out)

                            @php
                                array_push($day_sessions_arr, $employee_attendances[$a]);
                            @endphp

                        <!-- Case 3 Late -->
                        @elseif($session_time_in > $ws_time_in && $session_time_in < $ws_time_out && $session_time_out >= $ws_time_out)

                            @php
                                array_push($day_sessions_arr, $employee_attendances[$a]);
                            @endphp

                        <!-- Case 4 Late and Early Out-->
                        @elseif($session_time_in > $ws_time_in && $session_time_out < $ws_time_out)
                            @php
                                array_push($day_sessions_arr, $employee_attendances[$a]);
                            @endphp
                        @endif
                        <!-- Get Session Array value -->
                    @endif

                    
                @endforeach

                @if($day_sessions_arr == [])
                    @php
                        $session_attendance_time_in = "Absent";
                        $session_attendance_time_out = "Absent";
                    @endphp
                @else
                    @php
                        $session_attendance_time_in = date('H:i',$day_sessions_arr[0]['time_in']);
                        $session_attendance_time_out = date('H:i',$day_sessions_arr[count($day_sessions_arr) - 1]['time_out']);
                    @endphp
                @endif
                @if($employee_workshift->{$date_code_day.'_shift'} != 0)
                <td>{{$session_attendance_time_in}}</td>
                <td>{{$session_attendance_time_out}}</td>
                @else
                <td>Rest Day</td>
                <td>Rest Day</td>
                @endif
            </tr>
            @endfor


            @endforeach




    </tbody>
</table>