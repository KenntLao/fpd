<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_overtime_requests;
use App\hris_overtime_categories;
use App\hris_projects;

class OvertimeRequestController extends Controller
{
    public function index()
    {
        $overtimeRequests = hris_overtime_requests::paginate(10);
        return view('pages.admin.overtime.overtimeRequests.index', compact('overtimeRequests'));
    }

    public function create(hris_overtime_requests $overtimeRequest)
    {
        $overtimeCategories = hris_overtime_categories::all();
        $projects = hris_projects::all();
        return view('pages.admin.overtime.overtimeRequests.create', compact('overtimeRequest', 'overtimeCategories', 'projects'));
    }

    public function store(Request $request)
    {
        $overtimeRequest = new hris_overtime_requests();
        if($this->validatedData()) {
            $overtimeRequest->employee = request('employee');
            $overtimeRequest->category = request('category');
            $overtimeRequest->start_time = request('start_time');
            $overtimeRequest->end_time = request('end_time');
            $overtimeRequest->project = request('project');
            $overtimeRequest->notes = request('notes');
            $overtimeRequest->status = 'Pending';
            $overtimeRequest->save();
            return redirect('/hris/pages/admin/overtime/overtimeRequests/index')->with('success', 'Overtime Request successfully added');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_overtime_requests $overtimeRequest)
    {
        $overtimeCategories = hris_overtime_categories::all();
        $projects = hris_projects::all();
        return view('pages.admin.overtime.overtimeRequests.edit', compact('overtimeRequest', 'overtimeCategories', 'projects'));
    }

    public function update(hris_overtime_requests $overtimeRequest, Request $request)
    {
        if($this->validatedData()) {
            $overtimeRequest->employee = request('employee');
            $overtimeRequest->category = request('category');
            $overtimeRequest->start_time = request('start_time');
            $overtimeRequest->end_time = request('end_time');
            $overtimeRequest->project = request('project');
            $overtimeRequest->notes = request('notes');
            $overtimeRequest->status = 'Pending';
            $overtimeRequest->update();
            return redirect('/hris/pages/admin/overtime/overtimeRequests/index')->with('success', 'Overtime Request successfully updated');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function updateStatus(hris_overtime_requests $overtimeRequest, Request $request)
    {
        $overtimeRequest->status = request('status');
        $overtimeRequest->update();
        return redirect('/hris/pages/admin/overtime/overtimeRequests/index')->with('success', 'Overtime Request status successfully updated!');
    }

    public function destroy(hris_overtime_requests $overtimeRequest)
    {
        $overtimeRequest->delete();
        return redirect('/hris/pages/admin/overtime/overtimeRequests/index')->with('success', 'Overtime Request successfully deleted');
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee' => 'required',
            'category' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);
    }

}
