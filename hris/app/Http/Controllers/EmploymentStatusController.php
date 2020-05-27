<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_employment_statuses;

class EmploymentStatusController extends Controller
{
    public function index()
    {
        $employmentStatuses = hris_employment_statuses::paginate(10);
        return view('pages.admin.jobDetails.employmentStatuses.index', compact('employmentStatuses'));
    }

    public function create(hris_employment_statuses $employmentStatus)
    {
        return view('pages.admin.jobDetails.employmentStatuses.create', compact('employmentStatus'));
    }

    public function store(Request $request)
    {
        $employmentStatus = new hris_employment_statuses();
        if($this->validatedData()) {
            $employmentStatus->name = request('name');
            $employmentStatus->description = request('description');
            $employmentStatus->save();
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment Status successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employment_statuses $employmentStatus)
    {
        return view('pages.admin.jobDetails.employmentStatuses.edit', compact('employmentStatus'));
    }

    public function update(hris_employment_statuses $employmentStatus ,Request $request)
    {
        if($this->validatedData()) {
            $employmentStatus->name = request('name');
            $employmentStatus->description = request('description');
            $employmentStatus->update();
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment Status successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employment_statuses $employmentStatus)
    {
        $employmentStatus->delete();
        return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment Status successfully deleted!');
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'

        ]);

    }

}
