<?php

namespace App\Http\Controllers;

use App\hris_employee;
use App\hris_leave_groups;
use App\hris_leave_types;
use App\hris_leave_rules;
use App\hris_leave_group_employees;
use App\hris_leaves;
use Illuminate\Http\Request;

class LeaveEntitlementController extends Controller
{
    //
    public function index()
    {
        $leave_group_employee = hris_leave_group_employees::all();
        $emp_id = $_SESSION['sys_id'];
        $leaveGroup_ids = hris_leave_group_employees::where('employee_id', $emp_id)->get('leave_group_id');

        foreach ($leaveGroup_ids as $leaveGroup_id) {
            $lg_id = $leaveGroup_id->leave_group_id;
            $leave_groups_rules = hris_leave_rules::where('leave_group_id', $lg_id)->leftJoin('hris_leave_types', 'hris_leave_rules.leave_type_id', '=', 'hris_leave_types.id')->get();
        }
        if(isset($leave_groups_rules)){
            return view('pages.leaveManagement.leaveEntitlements.index', compact('leave_group_employee', 'leave_groups_rules'));
        }else {
            return back()->withErrors('Please add Employee to a Leave Group');
        }
    }

    public function entitlement()
    {
        
    }
}
