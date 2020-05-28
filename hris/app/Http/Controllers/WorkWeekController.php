<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_work_weeks;
use App\hris_countries;

class WorkWeekController extends Controller
{
    public function index()
    {
        $workWeeks = hris_work_weeks::paginate(10);
        return view('pages.admin.leave.workWeeks.index', compact('workWeeks'));
    }

    public function create(hris_work_weeks $workWeek)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.workWeeks.create', compact('workWeek', 'countries'));
    }

    public function store(Request $request)
    {
        $workWeek = new hris_work_weeks();
        if($this->validatedData()) {
            $workWeek->day = request('day');
            $workWeek->status = request('status');
            $workWeek->country = request('country');
            $workWeek->save();
            return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_work_weeks $workWeek)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.workWeeks.edit', compact('workWeek', 'countries'));
    }

    public function update(hris_work_weeks $workWeek, Request $request)
    {
        if($this->validatedData()) {
            $workWeek->day = request('day');
            $workWeek->status = request('status');
            $workWeek->country = request('country');
            $workWeek->update();
            return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_work_weeks $workWeek)
    {
        $workWeek->delete();
        return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'day' => 'required',
            'status' => 'required'
        ]);
    }

}
