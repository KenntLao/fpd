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

    }

    public function show($id)
    {

    }

    public function edit(hris_leave_types $leaveType)
    {
        $leaveGroup = hris_leave_groups::all();
        return view('pages.admin.leave.leaveTypes.edit', compact('leaveType', 'leaveGroup'));
    }

    public function update(hris_leave_types $leaveType, Request $request)
    {

    }

    public function destroy(hris_leave_types $leaveType)
    {

    }

    protected function validatedData()
    {
        return request()->validate([

        ]);
    }

}
