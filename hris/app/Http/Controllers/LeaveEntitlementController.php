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
            $sl_credits = hris_employee::where('id',$id)->pluck('sl_credit')->first();
            $vl_credits = hris_employee::where('id',$id)->pluck('vl_credit')->first();

            return view('pages.leaveManagement.leaveEntitlements.index', compact('sl_credits','vl_credits'));
        } else {
            return back()->withErrors('Please add Employee to a Leave Group');
        }
            
            
    }
}
