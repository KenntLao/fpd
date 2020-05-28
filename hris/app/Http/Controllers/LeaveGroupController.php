<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $leaveGroup = new hris_leave_groups();
        if ($this->validatedData()) {
            $leaveGroup->name = request('name');
            $leaveGroup->details = request('details');
            $leaveGroup->save();
            return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave Group successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }

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
        if ($this->validatedData()) {
            $leaveGroup->name = request('name');
            $leaveGroup->details = request('details');
            $leaveGroup->update();
            return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave Group successfully updated!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_groups $leaveGroup)
    {
        $leaveGroup->delete();
        return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave Group successfully deleted!');
    }
    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }
}
