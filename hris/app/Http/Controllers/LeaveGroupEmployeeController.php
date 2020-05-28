<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_group_employees;
use App\hris_leave_groups;

class LeaveGroupEmployeeController extends Controller
{
    public function index()
    {
        $leaveGroupEmployees = hris_leave_group_employees::paginate(10);
        return view('pages.admin.leave.leaveGroupEmployees.index', compact('leaveGroupEmployees'));
    }

    public function create(hris_leave_group_employees $leaveGroupEmployee)
    {
        $leaveGroups = hris_leave_groups::all();
        return view('pages.admin.leave.leaveGroupEmployees.create', compact('leaveGroupEmployee', 'leaveGroups'));
    }

    public function store(Request $request)
    {
        $leaveGroupEmployee = new hris_leave_group_employees();
        if ($this->validatedData()) {
            $leaveGroupEmployee->employee = request('employee');
            $leaveGroupEmployee->leave_group = request('leave_group');
            $leaveGroupEmployee->save();
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave Group Employee successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_group_employees $leaveGroupEmployee)
    {
        $leaveGroups = hris_leave_groups::all();
        return view('pages.admin.leave.leaveGroupEmployees.edit', compact('leaveGroupEmployee', 'leaveGroups'));
    }

    public function update(hris_leave_group_employees $leaveGroupEmployee, Request $request)
    {
        if ($this->validatedData()) {
            $leaveGroupEmployee->employee = request('employee');
            $leaveGroupEmployee->leave_group = request('leave_group');
            $leaveGroupEmployee->update();
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave Group Employee successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_group_employees $leaveGroupEmployee)
    {
        $leaveGroupEmployee->delete();
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave Group Employee successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee' => 'required',
            'leave_group' => 'required'
        ]);
    }

}
