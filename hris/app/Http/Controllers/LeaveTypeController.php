<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_groups;
use App\hris_leave_types;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = hris_leave_types::paginate(10);
        return view('pages.admin.leave.leaveTypes.index', compact('leaveTypes'));
    }

    public function create(hris_leave_types $leaveType)
    {
        $leaveGroups = hris_leave_groups::all();
        return view('pages.admin.leave.leaveTypes.create', compact('leaveType', 'leaveGroups'));
    }

    public function store(Request $request)
    {
        $leaveType = new hris_leave_types();
        if($this->validatedData()) {
            $leaveType->name = request('name');
            $leaveType->leaves_per_period = request('leaves_per_period');
            $leaveType->supervisor_leave_assign = request('supervisor_leave_assign');
            $leaveType->employee_can_apply = request('employee_can_apply');
            $leaveType->apply_beyond_current = request('apply_beyond_current');
            $leaveType->leave_accrue = request('leave_accrue');
            $leaveType->carried_forward = request('carried_forward');
            $leaveType->carried_forward_percentage = request('carried_forward_percentage');
            $leaveType->max_carried_forward_amount = request('max_carried_forward_amount');
            $leaveType->carried_forward_leave_availability = request('carried_forward_leave_availability');
            $leaveType->proportionate_on_joined_date = request('proportionate_on_joined_date');
            $leaveType->employee_leave_period = request('employee_leave_period');
            $leaveType->send_notification_emails = request('send_notification_emails');
            $leaveType->leave_group = request('leave_group');
            $leaveType->leave_color = request('leave_color');
            $leaveType->save();
            return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_types $leaveType)
    {
        $leaveGroups = hris_leave_groups::all();
        return view('pages.admin.leave.leaveTypes.edit', compact('leaveType', 'leaveGroups'));
    }

    public function update(hris_leave_types $leaveType, Request $request)
    {
        if($this->validatedData()) {
            $leaveType->name = request('name');
            $leaveType->leaves_per_period = request('leaves_per_period');
            $leaveType->supervisor_leave_assign = request('supervisor_leave_assign');
            $leaveType->employee_can_apply = request('employee_can_apply');
            $leaveType->apply_beyond_current = request('apply_beyond_current');
            $leaveType->leave_accrue = request('leave_accrue');
            $leaveType->carried_forward = request('carried_forward');
            $leaveType->carried_forward_percentage = request('carried_forward_percentage');
            $leaveType->max_carried_forward_amount = request('max_carried_forward_amount');
            $leaveType->carried_forward_leave_availability = request('carried_forward_leave_availability');
            $leaveType->proportionate_on_joined_date = request('proportionate_on_joined_date');
            $leaveType->employee_leave_period = request('employee_leave_period');
            $leaveType->send_notification_emails = request('send_notification_emails');
            $leaveType->leave_group = request('leave_group');
            $leaveType->leave_color = request('leave_color');
            $leaveType->update();
            return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_types $leaveType)
    {
        $leaveType->delete();
        return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'leaves_per_period' => 'required',
            'supervisor_leave_assign' => 'required',
            'employee_can_apply' => 'required',
            'apply_beyond_current' => 'required',
            'leave_accrue' => 'required',
            'carried_forward' => 'required',
            'carried_forward_percentage' => 'required',
            'max_carried_forward_amount' => 'required',
            'carried_forward_leave_availability' => 'required',
            'proportionate_on_joined_date' => 'required',
            'employee_leave_period' => 'required',
            'send_notification_emails' => 'required',
            'leave_color' => 'required'
        ]);
    }

}
