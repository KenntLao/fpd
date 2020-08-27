<?php

namespace App\Http\Controllers;

use App\hris_leaves;
use Illuminate\Http\Request;

class leaveCalendarController extends Controller
{
    public function index()
    {
        $id = $_SESSION['sys_id'];
        $events = [];
        $emp_leave_pending = hris_leaves::where('employee_id',$id)->where('status',0)->get();
        $emp_leave_approved = hris_leaves::where('employee_id', $id)->where('status', 1)->get();
        $emp_leave_denied = hris_leaves::where('employee_id', $id)->where('status', 2)->get();

        foreach($emp_leave_pending as $pending) {
            $events[] = [
                'title' => 'Pending',
                'start' => date("Y-m-d",strtotime($pending->leave_start_date)),
                'color' => '#5BC0DE',
            ];
        }
        foreach ($emp_leave_approved as $approved) {
            $events[] = [
                'title' => 'Approved',
                'start' => date("Y-m-d", strtotime($approved->leave_start_date)),
                'color' => '#5CB85C',
            ];
        }
        foreach ($emp_leave_denied as $denied) {
            $events[] = [
                'title' => 'Denied',
                'start' => date("Y-m-d", strtotime($denied->leave_start_date)),
                'color' => '#D9534F',
            ];
        }
        

        return view('pages.leaveManagement.leaveCalendar.index', compact('events'));
    }
}
