<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_periods;

class LeavePeriodController extends Controller
{
    public function index()
    {
        $leavePeriods = hris_leave_periods::paginate(10);
        return view('pages.admin.leave.leavePeriods.index', compact('leavePeriods'));
    }

    public function create(hris_leave_periods $leavePeriod)
    {
        return view('pages.admin.leave.leavePeriods.create', compact('leavePeriod'));
    }

    public function store(Request $request)
    {
        $leavePeriod = new hris_leave_periods();
        if($this->validatedData()) {
            $leavePeriod->name = request('name');
            $leavePeriod->start = request('start');
            $leavePeriod->end = request('end');
            $leavePeriod->save();
            return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave Period successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_periods $leavePeriod)
    {
        return view('pages.admin.leave.leavePeriods.edit', compact('leavePeriod'));
    }

    public function update(hris_leave_periods $leavePeriod, Request $request)
    {
        if($this->validatedData()) {
            $leavePeriod->name = request('name');
            $leavePeriod->start = request('start');
            $leavePeriod->end = request('end');
            $leavePeriod->update();
            return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave Period successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_periods $leavePeriod)
    {
        $leavePeriod->delete();
        return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave Period successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);
    }

}
