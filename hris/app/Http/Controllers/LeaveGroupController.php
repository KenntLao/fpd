<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_leave_groups;

class LeaveGroupController extends Controller
{
    public function index()
    {
        $leaveGroups = hris_leave_groups::paginate(10);
        return view('pages.admin.leave.leaveGroups.index', compact('leaveGroups'));
    }

    public function create(hris_leave_groups $leaveGroup)
    {
        return view('pages.admin.leave.leaveGroups.create', compact('leaveGroup'));
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

    }

    public function edit(hris_leave_groups $leaveGroup)
    {
        return view('pages.admin.leave.leaveGroups.edit', compact('leaveGroup'));
    }

    public function update(hris_leave_groups $leaveGroup, Request $request)
    {

    }

    public function destroy(hris_leave_groups $leaveGroup)
    {

    }
}
