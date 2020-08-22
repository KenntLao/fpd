<?php

namespace App\Http\Controllers;

use App\hris_employee;
use App\hris_leave_groups;
use App\hris_leave_types;
use App\hris_leave_rules;
use App\hris_leave_group_employees;
use Illuminate\Http\Request;

class LeaveEntitlementController extends Controller
{
    //
    public function index()
    {
        
        

       
        return view('pages.leaveManagement.leaveEntitlements.index');
    }

    public function entitlement()
    {
        $emp_id = $_SESSION['sys_id'];
        $leaveGroup_ids = hris_leave_group_employees::where('employee_id', $emp_id)->get('leave_group_id');
        foreach ($leaveGroup_ids as $leaveGroup_id) {
            $lg_id = $leaveGroup_id->leave_group_id;
            $leave_groups_rules = hris_leave_rules::where('leave_group_id', $lg_id)->leftJoin('hris_leave_types', 'hris_leave_rules.leave_type_id', '=', 'hris_leave_types.id')->get();
        }
    }
}
