<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_holidays;
use App\hris_countries;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = hris_holidays::paginate(10);
        return view('pages.admin.leave.holidays.index', compact('holidays'));
    }

    public function create(hris_holidays $holiday)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.holidays.create', compact('holiday', 'countries'));
    }

    public function store(Request $request)
    {
        $holiday = new hris_holidays();
        if($this->validatedData()) {
            $holiday->name = request('name');
            $holiday->holiday_date = request('holiday_date');
            $holiday->status = request('status');
            $holiday->country = request('country');
            $holiday->save();
            return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_holidays $holiday)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.holidays.edit', compact('holiday', 'countries'));
    }

    public function update(hris_holidays $holiday, Request $request)
    {
        if($this->validatedData()) {
            $holiday->name = request('name');
            $holiday->holiday_date = request('holiday_date');
            $holiday->status = request('status');
            $holiday->country = request('country');
            $holiday->update();
            return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_holidays $holiday)
    {
        $holiday->delete();
        return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'holiday_date' => 'required',
            'status' => 'required'
        ]);
    }

}
