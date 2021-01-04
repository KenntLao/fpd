<?php

namespace App\Http\Controllers;

use App\hris_employee;
use App\hris_leave_entitlement;
use App\hris_leave_types;
use App\hris_leaves;
use Illuminate\Http\Request;

class LeaveEntitlementController extends Controller
{
    //
    public function index()
    {
        if($_SESSION['sys_account_mode'] == 'employee'){
            $id = $_SESSION['sys_id'];

            $leave_entitlements = hris_leave_entitlement::where('employee_id',$id)->get();
            
            return view('pages.leaveManagement.leaveEntitlements.index', compact('leave_entitlements'));
        } else {
            return back()->withErrors('Please add Employee to a Leave Group');
        }
            
            
    }
}
